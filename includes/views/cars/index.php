        <main>
            <section class="small"><h3><i class="fa fa-phone" aria-hidden="true"></i>Call us now on 01307 461234</h3></section>

            <section class="cars">

<?php foreach ($list as $car) {
    if (file_exists('img/cars/' . $car->registration . '.jpg')) {
        $image = $car->registration . '.jpg';
    } else if (file_exists('img/cars/' . $car->registration . '.png')) {
        $image = $car->registration . '.png';
    } else if (file_exists('img/cars/' . $car->registration . '.jpeg')) {
        $image = $car->registration . '.jpeg';
    } else {
        $image = 'not_found.png';
    }
    ?>
    <div class="car">
        <div class="image">
            <img src="img/cars/<?= $image; ?>" />
        </div>
        <div class="details">
            <h1><?= $car->manufacturer; ?> <?= $car->model; ?></h1>
            <table>
                <tr><td><b>Condition:</b></td><td><?= $car->condition; ?></td></tr>
                <tr><td><b>Mileage:</b></td><td><?= $car->mileage; ?></td></tr>
                <tr><td><b>Year:</b></td><td><?= $car->year; ?></td></tr>
                <tr><td><b>Engine:</b></td><td><?= $car->engine; ?></td></tr>
                <tr><td><b>Fuel Type:</b></td><td><?= $car->fuelType; ?></td></tr>
                <tr><td><b>Price:</b></td><td><b>£<?= $car->price; ?></b></td></tr>
            </table>
            <h2><?= ($car->sold ? 'Sold' : '') ?></h2>
        </div>

        <div class="buttons">
            <a href="tel:01307461234" class="button">Call Us</a>
            <a href="contact" class="button">Enquire</a>
            <a href="cars/<?= $car->vehicleId; ?>" class="button">More Details</a>
        </div>
    </div>
<?php } ?>

                <div class="cars-navigation">
                    <p><?= $prevNextString; ?></p>

                    <p>
                        <?php
                        // Create a back link if the current page is greater than 0
                        if ($page > 0) { ?>
                            <a href="cars/page/<?= $page - 1 ?>"> &lt; Prev</a>
                        <?php }
                        // Create a forward link if more records exist
                        if ($startRow + $showMax < $total) { ?>
                            <a href="cars/page/<?= $page + 1 ?>"> Next &gt; </a>
                        <?php } ?>
                    </p>
                </div>
            </section>


        </main>
