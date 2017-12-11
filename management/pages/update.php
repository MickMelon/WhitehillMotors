<?php

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $vehicleId = htmlentities($_GET['id']);

    $car = Car::findByVehicleId($vehicleId);

    if ($car->model == '') {
        header("Location: index.php?page=error");
    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        Car::delete($vehicleId);
        header("Location: index.php?page=home");
    }

    if (isset($_POST['submit'])) {
        $engine = $_POST['engine'];
        $year = $_POST['year'];
        $registration = $_POST['registration'];
        $mileage = $_POST['mileage'];
        $fueltype = $_POST['fueltype'];
        $features = $_POST['features'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        require_once('includes/upload.php');

        Car::update($vehicleId, $engine, $year, $registration, $mileage, $fueltype, $features, $description, $price);

        $success[] = 'Vehicle successfully updated.';
    }
} else {
    header("Location: index.php?page=error");
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

    <form name="addcar" method="post" action="" enctype="multipart/form-data">
        Engine: <input type="text" name="engine" value="<?= $car->engine; ?>" required />
        Year: <input type="text" name="year" value="<?= $car->year; ?>" required />
        Registration: <input type="text" name="registration" value="<?= $car->registration; ?>" required />
        Mileage: <input type="text" name="mileage" value="<?= $car->mileage; ?>" required />

        Fuel Type:
        <select name="fueltype">
            <option value="Petrol"<?= $car->fuelType == 'Petrol' ? ' selected' : ''?>>Petrol</option>
            <option value="Diesel"<?= $car->fuelType == 'Diesel' ? ' selected' : ''?>>Diesel</option>
            <option value="Electric"<?= $car->fuelType == 'Electric' ? ' selected' : ''?>>Electric</option>
            <option value="Hybrid"<?= $car->fuelType == 'Hybrid' ? ' selected' : ''?>>Hybrid</option>
            <option value="LPG"<?= $car->fuelType == 'LPG' ? ' selected' : ''?>>LPG</option>
        </select>

        Features: <input type="text" name="features" value="<?= $car->features; ?>" required />
        Description: <input type="text" name="description" value="<?= $car->description; ?>" required />
        Price: <input type="text" name="price" value="<?= $car->price; ?>" required />
        Image: <input type="file" name="image" id="image" />
        <input type="submit" name="submit" value="Update Vehicle" />
    </form>
</div>

<script>
function validateForm() {
    var engine = document.forms["form"]["engine"].value;
    var year = document.forms["form"]["year"].value;
    var registration = document.forms["form"]["registration"].value;
    var mileage = document.forms["form"]["mileage"].value;
    var features = document.forms["form"]["features"].value;
    var description = document.forms["form"]["description"].value;
    var price = document.forms["form"]["price"].value;

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

}
</script>
