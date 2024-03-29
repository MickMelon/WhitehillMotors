        <main>
            <section class="small"><h3><i class="fa fa-phone" aria-hidden="true"></i>Call us now on 01307 461234</h3></section>

            <section class="filter-cars">
                <div class="filter-cars-title">
                    <h1>Filter Results</h1>
                    <p>Using the form below makes it easier to narrow down results to find your dream car!</p>
                </div>

                <div class="filter-cars-forms">
                    <form id="manufacturer-model" name="manufacturer-model" method="post" action="">
                        <table>
                            <tr>
                                <td>Manufacturer:</td>
                                <td>
                                    <select id="manufacturer" onchange="submitForm('manufacturer-model')" name="manufacturer" form="manufacturer-model">
                                        <option value="any">Any</option>
                                        <?php foreach ($manufacturers as $manufacturer) { ?>
                                            <option value="<?= $manufacturer['ManufacturerID']; ?>" <?php if (isset($_POST['manufacturer']) && $manufacturer['ManufacturerID'] == $_POST['manufacturer']) echo ' selected'?>>
                                                <?= $manufacturer['Name']; ?>

                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Model:</td>
                                <td>
                                    <select onchange="setModel()" name="model" id="model" form="manufacturer-model">
                                        <option value="any">Any</option>
                                        <?php foreach ($models as $model) { ?>
                                            <option value="<?= $model['ModelID']; ?>"><?= $model['Name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <form id="filter" name="filter" method="post" action="" enctype="multipart/form-data" id="filterForm">
                        <input type="text" name="manufacturerId" id="manufacturerId" style="display: none;" value="any" />
                        <input type="text" name="modelId" id="modelId" style="display: none;" value="any" />
                        <table>
                            <tr>
                                <td>Fuel Type:</td>
                                <td>
                                    <select name="fuelType">
                                        <option value="any">Any</option>
                                        <option value="petrol">Petrol</option>
                                        <option value="diesel">Diesel</option>
                                        <option value="electric">Electric</option>
                                        <option value="hybrid">Hybrid</option>
                                        <option value="lpg">LPG</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Condition:</td>
                                <td>
                                    <select name="condition">
                                        <option value="any">Any</option>
                                        <option value="new">New</option>
                                        <option value="used">Used</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Age:</td>
                                <td><input type="number" name="age" /></td>
                            </tr>
                            <tr>
                                <td>Mileage From:</td>
                                <td><input type="number" name="minMileage" /></td>
                            </tr>
                            <tr>
                                <td>Mileage To:</td>
                                <td><input type="number" name="maxMileage" /></td>
                            </tr>
                            <tr>
                                <td>Price From:</td>
                                <td><input type="number" name="minPrice" /></td>
                            </tr>
                            <tr>
                                <td>Price To:</td>
                                <td><input type="number" name="maxPrice" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="submit" value="Filter" form="filter"/></td>
                            </tr>
                        </table>

                    </form>
                </div>
            </section>

            <section class="cars">

<?php foreach ($list as $car) {
    if (file_exists('img/cars/' . $car->registration . '/0.jpg')) {
        $image = $car->registration . '/0.jpg';
    } else if (file_exists('img/cars/' . $car->registration . '/0.png')) {
        $image = $car->registration . '/0.png';
    } else if (file_exists('img/cars/' . $car->registration . '/0.jpeg')) {
        $image = $car->registration . '/0.jpeg';
    } else {
        $image = 'not_found.png';
    }
    ?>
    <div class="car">
        <div class="image">
            <img src="img/cars/<?= $image; ?>" />
            <div class="sold-text" style=""><?= $car->sold ? 'CAR SOLD' : '' ?></div>
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

<script>
    setManufacturer();

    function submitForm(formId) {
        var form = document.getElementById(formId);
        if (form) {
            form.submit();
        }
    }

    function setModel() {
        var model = document.getElementById('model');
        var modelId = model.options[model.selectedIndex].value;
        document.getElementById('modelId').value = modelId;
    }

    function setManufacturer() {
        var manufacturer = document.getElementById('manufacturer');
        var manufacturerId = manufacturer.options[manufacturer.selectedIndex].value;
        document.getElementById('manufacturerId').value = manufacturerId;
    }
</script>
