<?php
    class CarsController {
        public function index() {
            // This method isn't actually used anymore since the pages
            // method was introduced
            $list = Car::all();
            require_once('includes/views/cars/index.php');
        }

        public function page2() {
            // Initialize all variables to be used
            $page = 0;
            $total = 0;
            $startRow = 0;
            $showMax = 5;

            // Check if the page parameter has been set. If it has, set $page
            // to be the value of the parameter. Otherwise page will remain 0
            if (isset($_GET['page']) && !empty($_GET['page'])) {
                $page = $_GET['page'];
            }

            // These parameter variables are passed by reference so that the
            // allPage method modifies the value so we can use them after
            $list = Car::allPage($page, $total, $startRow, $showMax);

            // Build previous/next string to be displayed on the page
            $prevNextString = CarsController::buildPrevNextString($startRow, $showMax, $total);

            require_once('includes/views/cars/index.php');
        }

        public function page() {
            $manufacturers = Car::getAllManufacturers();
            $models = Car::getAllModelsForManufacturer($manufacturers[0]['ManufacturerID']);

            if (isset($_POST['manufacturer'])) {
                echo "wut";
                $models = Car::getAllModelsForManufacturer($_POST['manufacturer']);
            }

            // Initialize all variables to be used
            $page = 0;
            $total = 0;
            $startRow = 0;
            $showMax = 5;

            if (isset($_GET['page']) && !empty($_GET['page'])) {
                $page = $_GET['page'];
            }

            // We need to get all the filter results shit here..

            $manufacturerId = isset($_POST['manufacturerId']) && $_POST['manufacturerId'] != '' ? $_POST['manufacturerId'] : 'any';
            $modelId = isset($_POST['modelId']) && $_POST['modelId'] != '' ? $_POST['modelId'] : 'any';
            $maxAge = isset($_POST['maxAge']) && $_POST['maxAge'] != '' ? $_POST['maxAge'] : 0;

            $minMileage = isset($_POST['minMileage']) && $_POST['minMileage'] != '' ? $_POST['minMileage'] : 0;
            $maxMileage = isset($_POST['maxMileage']) && $_POST['maxMileage'] != '' ? $_POST['maxMileage'] : 0;

            $fuelType = isset($_POST['fuelType']) && $_POST['fuelType'] != '' ? $_POST['fuelType'] : 'any';
            $condition = isset($_POST['condition']) && $_POST['condition'] != '' ? $_POST['condition'] : 'any';

            $minPrice = isset($_POST['minPrice']) && $_POST['minPrice'] != '' ? $_POST['minPrice'] : 0;
            $maxPrice = isset($_POST['maxPrice']) && $_POST['maxPrice'] != '' ? $_POST['maxPrice'] : 0;

            $list = Car::allFilter($page, $total, $startRow, $showMax, $manufacturerId, $modelId, $maxAge, $minMileage, $maxMileage,
             $fuelType, $condition, $minPrice, $maxPrice);

            // These parameter variables are passed by reference so that the
            // allPage method modifies the value so we can use them after
            //    $list = Car::allPage($page, $total, $startRow, $showMax);

            // Build previous/next string to be displayed on the page
            $prevNextString = CarsController::buildPrevNextString($startRow, $showMax, $total);

            require_once('includes/views/cars/index.php');
        }

        public function single2() {
            // Check if the id parameter has been set
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                // Get the car that has that id
                $vehicleId = htmlentities($_GET['id']);
                $car = Car::findByVehicleId($vehicleId);

                // Check if a car was found
                if ($car->model == '') {
                    // If no car was found display the error page
                    call('pages', 'error');
                } else {
                    // Check to see if a file exists as png, jpg or jpeg
                    if (file_exists('img/cars/' . $car->registration . '.jpg')) {
                        $image = $car->registration . '.jpg';
                    } else if (file_exists('img/cars/' . $car->registration . '.png')) {
                        $image = $car->registration . '.png';
                    } else if (file_exists('img/cars/' . $car->registration . '.jpeg')) {
                        $image = $car->registration . '.jpeg';
                    } else {
                        // If it doesn't exist display the not found image
                        $image = 'not_found.png';
                    }
                    // Display the single car page
                    require_once('includes/views/cars/single.php');
                }
            } else {
                // If there was no id then display the error page
                call('pages', 'error');
            }
        }

        public function single() {
            // Check if the id parameter has been set
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                // Get the car that has that id
                $vehicleId = htmlentities($_GET['id']);
                $car = Car::findByVehicleId($vehicleId);

                // Check if a car was found
                if ($car->model == '') {
                    // If no car was found display the error page
                    call('pages', 'error');
                } else {
                    // Loop for five times as this is the maximum amount of images we will have
                    for ($i = 0; $i < 5; $i++) {
                        // Check if the file is a png, jpg or jpeg
                        // If it is any of them, add the image url to the imageUrls array
                        if (file_exists('img/cars/' . $car->registration . '/' . $i . '.png')) {
                            $imageUrls[] = 'img/cars/' . $car->registration . '/' . $i . '.png';
                        }
                        else if (file_exists('img/cars/' . $car->registration . '/' . $i . '.jpg')) {
                            $imageUrls[] = 'img/cars/' . $car->registration . '/' . $i . '.jpg';
                        }
                        else if (file_exists('img/cars/' . $car->registration . '/' . $i . '.jpeg')) {
                            $imageUrls[] = 'img/cars/' . $car->registration . '/' . $i . '.jpeg';
                        }
                        else {
                            // Break out the loop cause if no image was found then there are't
                            // going to be any more
                            break;
                        }
                    }
                    // Check to see if any images were found
                    if (empty($imageUrls)) {
                        // If there weren't any found, set the image to be not_found.png
                        $imageUrls[] = 'not_found.png';
                    }

                    // Display the single car page
                    require_once('includes/views/cars/single.php');
                }
            } else {
                // If there was no id then display the error page
                call('pages', 'error');
            }
        }

        public static function buildPrevNextString($startRow, $showMax, $total) {
            // Begin the string
            $prevNextString = 'Displaying ';

            // The value of startRow is zero-based, so we need to add 1 to
            // get a more user-friendly number. So startRow will display 1 on the
            // first page and 6 on the second page
            $prevNextString .= $startRow + 1;

            // Check if startRow+1 is less than the total number of records.
            if ($startRow + 1 < $total) {
                // If it is, that means the current page is displaying a range of
                // records, so it adds the text "to" with a space either side
                $prevNextString .= ' to ';

                // We need to work out the top number of the range now
                // Add the value of the start row to the maximum number of records
                // to be shown on the page.
                if ($startRow + $showMax < $total) {
                    // If the result is less, startRow + showMax
                    // will give the number of the last record on the page
                    $prevNextString .= ($startRow + $showMax);
                } else {
                    // If the result is equal to or greater than the total, the
                    // total is displayed instead
                    $prevNextString .= $total;
                }
            }
            // Finally add the total number of records to the string.
            // If it was the last page, the resulting string would be something like
            // Displaying 11 of 11
            // If it wasn't the last page, the resulting string would be something like
            // Displaying 1 to 5 of 11
            $prevNextString .= " of $total";

            return $prevNextString;
        }
    }
?>
