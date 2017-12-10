<?php
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $vehicleId = htmlentities($_GET['id']);
        $car = Car::findByVehicleId($vehicleId);

        if ($car->model == '') {
            header("Location: index.php?page=error");
        }

        if (file_exists('img/cars/' . $car->registration . '.jpg')) {
            $image = $car->registration . '.jpg';
        } else if (file_exists('img/cars/' . $car->registration . '.png')) {
            $image = $car->registration . '.png';
        } else if (file_exists('img/cars/' . $car->registration . '.jpeg')) {
            $image = $car->registration . '.jpeg';
        } else {
            $image = 'not_found.png';
        }
    } else {
        header("Location: index.php?page=error");
    }
?>

<main>
    <section class="small"><h3><i class="fa fa-phone" aria-hidden="true"></i>Call us now on 01307 461234</h3></section>

    <section class="cars">
        <div class="single-car">
            <div class="single-car-top-row">
                <div class="gallery">
                    <img src="img/cars/<?= $image; ?>" />
                </div>
                <div class="details">
                    <div class="price">
                    </div>
                    <h3>Volkswagen Golf</h3>
                    <table>
                        <tr><td><b>Condition:</b></td><td><?= $car->condition; ?></td></tr>
                        <tr><td><b>Mileage:</b></td><td><?= $car->mileage; ?></td></tr>
                        <tr><td><b>Year:</b></td><td><?= $car->year; ?></td></tr>
                        <tr><td><b>Engine:</b></td><td><?= $car->engine; ?></td></tr>
                        <tr><td><b>Fuel Type:</b></td><td><?= $car->fuelType; ?></td></tr>
                        <tr><td><b>Price:</b></td><td><b>£<?= $car->price; ?></b></td></tr>
                    </table>
                    <p><?= $car->description; ?></p>
                </div>
            </div>

            <div class="single-car-bottom-row">
                <div class="buttons">
                    <a href="tel:01307461234" class="button">Call Us</a>
                    <a href="index.php?page=contact" class="button">Enquire</a>
                </div>
            </div>


        </div>


        <div class="cars-navigation">
            <p><a href="index.php?page=cars"><< Go back</a></p>
        </div>
    </section>


</main>
