<?php
$manufacturers = Car::getAllManufacturers();
$models = Car::getAllModelsForManufacturer($manufacturers[0]['ManufacturerID']);

if (isset($_POST['manufacturer'])) {
    $models = Car::getAllModelsForManufacturer($_POST['manufacturer']);
}

if (isset($_POST['submit'])) {
    $model = $_POST['modelId'];
    $engine = $_POST['engine'];
    $year = $_POST['year'];
    $registration = $_POST['registration'];
    $mileage = $_POST['mileage'];
    $fueltype = $_POST['fueltype'];
    $condition = $_POST['condition'];
    $features = $_POST['features'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    require_once('includes/upload.php');

    Car::insert($model, $engine, $year, $registration, $mileage, $fueltype, $condition, $features, $description, $price);

    $success[] = 'Vehicle successfully added.';
}
?>

<div class="container">
    <?php if (isset($errors)) {
        foreach ($errors as $error) { ?>
            <p><?= $error; ?></p>
    <?php }
    } else if (isset($success)) { ?>
        <p><?= $success[0]; ?></p>
    <?php } ?>


    <form id="manufacturer-model" name="manufacturer-model" method="post" action="">
        Manufacturer:
        <select onchange="submitForm('manufacturer-model')" name="manufacturer" form="manufacturer-model">
            <?php foreach ($manufacturers as $manufacturer) { ?>
                <option value="<?= $manufacturer['ManufacturerID']; ?>" <?php if (isset($_POST['manufacturer']) && $manufacturer['ManufacturerID'] == $_POST['manufacturer']) echo ' selected'?>>
                    <?= $manufacturer['Name']; ?>

                </option>
            <?php } ?>

        </select>

        Model:
        <select onchange="setModel()" name="model" id="model" form="manufacturer-model">
            <?php foreach ($models as $model) { ?>
                <option value="<?= $model['ModelID']; ?>"><?= $model['Name']; ?></option>
            <?php } ?>
        </select>
    </form>

    <form name="addcar" method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm()" id="form">
        <input type="text" name="modelId" id="modelId" style="display: none;" value="<?= $models[0]['ModelID']; ?>" />

        Engine: <input type="text" name="engine" required />
        Year: <input type="text" name="year" required />
        Registration: <input type="text" name="registration" required />
        Mileage: <input type="text" name="mileage" required />

        Fuel Type:
        <select name="fueltype">
            <option value="Petrol" selected>Petrol</option>
            <option value="Diesel">Diesel</option>
            <option value="Electric">Electric</option>
            <option value="Hybrid">Hybrid</option>
            <option value="LPG">LPG</option>
        </select>

        Condition:
        <select name="condition">
            <option value="New" selected>New</option>
            <option value="Used">Used</option>
        </select>

        Features: <input type="text" name="features" required />
        Description: <input type="text" name="description" required />

        Price: <input type="text" name="price" required />

        Image: <input type="file" name="imageUpload" id="imageUpload" multiple/>
        <input type="submit" name="submit" value="Add Vehicle" />
    </form>
</div>

<script>
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

    function validateForm() {
        var engine = document.forms["form"]["engine"].value;
        var year = document.forms["form"]["year"].value;
        var registration = document.forms["form"]["registration"].value;
        var mileage = document.forms["form"]["mileage"].value;
        var features = document.forms["form"]["features"].value;
        var description = document.forms["form"]["description"].value;
        var price = document.forms["form"]["price"].value;
        var imageUpload = document.getElementById("imageUpload").files;

        // is not a number
        if (isNaN(engine)) {
            alert("Engine size must be a number");
            return false;
        }
        if (isNaN(year)) {
            alert("Year must be a number");
            return false;
        }
        if (isNaN(mileage)) {
            alert("Mileage must be a number");
            return false;
        }
        if (isNaN(price)) {
            alert("Price must be a number!");
            return false;
        }

        // Check that there are no more than 5 images uploaded
        if (imageUpload.length > 5) {
            alert("You cannot upload more than 5 images!");
            return false;
        }
    }
</script>
