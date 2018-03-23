<?php
    class CarsController {
        public function index() {
            // This method isn't actually used anymore since the pages
            // method was introduced
            $list = Car::all();
            require_once('includes/views/cars/index.php');
        }

        public function page() {
            if (isset($_POST['modelId'])) echo "Fuck you dick head<br/>";
            else echo "you are a fucking arse hoel...<br/>";

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

            if (isset($_POST['page']) && !empty($_POST['page'])) {
                $page = $_POST['page'];
            }

            // We need to get all the filter results shit here...
            echo 'MODELID = ' . $_POST['modelId'] . '<br />';

            $modelId = isset($_POST['modelId']) && $_POST['modelId'] != '' ? $_POST['modelId'] : -1;
            $maxAge = isset($_POST['maxAge']) && $_POST['maxAge'] != '' ? $_POST['maxAge'] : 0;

            $minMileage = isset($_POST['minMileage']) && $_POST['minMileage'] != '' ? $_POST['minMileage'] : 0;
            $maxMileage = isset($_POST['maxMileage']) && $_POST['maxMileage'] != '' ? $_POST['maxMileage'] : 0;

            $fuelType = isset($_POST['fuelType']) && $_POST['fuelType'] != '' ? $_POST['fuelType'] : 'any';
            $condition = isset($_POST['condition']) && $_POST['condition'] != '' ? $_POST['condition'] : 'any';

            $minPrice = isset($_POST['minPrice']) && $_POST['minPrice'] != '' ? $_POST['minPrice'] : 0;
            $maxPrice = isset($_POST['maxPrice']) && $_POST['maxPrice'] != '' ? $_POST['maxPrice'] : 0;

            $list = Car::allFilter($page, $total, $startRow, $showMax, $modelId, $maxAge, $minMileage, $maxMileage,
             $fuelType, $condition, $minPrice, $maxPrice);

            // These parameter variables are passed by reference so that the
            // allPage method modifies the value so we can use them after
            //    $list = Car::allPage($page, $total, $startRow, $showMax);

            // Build previous/next string to be displayed on the page
            $prevNextString = CarsController::buildPrevNextString($startRow, $showMax, $total);

            require_once('includes/views/cars/index.php');
        }

        public function single() {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $vehicleId = htmlentities($_GET['id']);
                $car = Car::findByVehicleId($vehicleId);

                if ($car->model == '') {
                    $errorMessage = 'Cannot find a vehicle for the specified ID.';
                    require_once('includes/views/pages/error.php');
                } else {
                    if (file_exists('img/cars/' . $car->registration . '.jpg')) {
                        $image = $car->registration . '.jpg';
                    } else if (file_exists('img/cars/' . $car->registration . '.png')) {
                        $image = $car->registration . '.png';
                    } else if (file_exists('img/cars/' . $car->registration . '.jpeg')) {
                        $image = $car->registration . '.jpeg';
                    } else {
                        $image = 'not_found.png';
                    }
                    require_once('includes/views/cars/single.php');
                }
            } else {
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
