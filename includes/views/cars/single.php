<main>
    <section class="small"><h3><i class="fa fa-phone" aria-hidden="true"></i>Call us now on 01307 461234</h3></section>

    <section class="cars">

        <?php
        // Check to see if any images were found for this car
        if ($imageUrls[0] == 'not_found.png') {
        ?>
            Image not found!
            <img src="img/cars/not_found.png" />
        <?php
        } else {
        // If there are images, we can create the gallery and add the images to it
        ?>
            <div class="gallery">
                <?php
                for ($i = 0; $i < count($imageUrls); $i++) {
                // Loop through every image and add it in the gallery
                ?>
                    <div class="gallery-slides">
                        <div class="numbertext"><?= $i+1 ?> / <?= count($imageUrls) ?></div>
                        <div class="gallery-image" style="background-image: url(<?= $imageUrls[$i] ?>);"></div>
                    </div>
                <?php
                } // end-for
                ?>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>

                <!-- Image text -->
                <div class="caption-container">
                <p id="caption"></p>
                </div>
            </div>
        <?php
        } // end-if
        ?>
        <div class="single-car">
            <div class="single-car-top-row">
                <div class="details">
                    <div class="price">
                    </div>
                    <h3><?= $car->manufacturer; ?> <?= $car->model; ?></h3>
                    <table>
                        <tr><td><b>Condition:</b></td><td><?= $car->condition; ?></td></tr>
                        <tr><td><b>Mileage:</b></td><td><?= $car->mileage; ?></td></tr>
                        <tr><td><b>Year:</b></td><td><?= $car->year; ?></td></tr>
                        <tr><td><b>Engine:</b></td><td><?= $car->engine; ?></td></tr>
                        <tr><td><b>Fuel Type:</b></td><td><?= $car->fuelType; ?></td></tr>
                        <tr><td><b>Price:</b></td><td><b>£<?= $car->price; ?></b></td></tr>
                    </table>
                    <p><?= $car->description; ?></p>
                    <br />
                    <p><?= $car->features; ?></p>
                </div>
            </div>

            <div class="single-car-bottom-row">
                <div class="buttons">
                    <a href="tel:01307461234" class="button">Call Us</a>
                    <a href="contact" class="button">Enquire</a>
                </div>
            </div>


        </div>


        <div class="cars-navigation">
            <p><a href="index.php?page=cars"><< Go back</a></p>
        </div>
    </section>


</main>

<script type="text/javascript" src="js/gallery.js"></script>
