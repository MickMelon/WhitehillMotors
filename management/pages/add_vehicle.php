<?php
$manufacturers = Car::getAllManufacturers();
$models = Car::getAllModelsForManufacturer($manufacturers[0]['ManufacturerID']);

if (isset($_POST['manufacturer'])) {
    $models = Car::getAllModelsForManufacturer($_POST['manufacturer']);
}

$done = 0;
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

    echo $_FILES['image']['name'];

    // do this when details are done
    if (isset($_FILES['image'])) {
        echo "image";

      $errors = array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

      $extensions = array("jpeg","jpg","png");

      if (!in_array($file_ext, $extensions)) {
         $errors[] = "File extension not allowed, please choose a JPEG or PNG file.";
      }

      if ($file_size > 2097152) {
         $errors[] = 'File size cannot be larger than 2MB';
      }

      if (empty($errors)) {
         $temp = explode(".", $file_name);
         $newname = $registration . '.' . end($temp);
         move_uploaded_file($file_tmp, "../img/cars/". $newname);
         echo "Success";
      } else {
         print_r($errors);
      }

      $done = 1;
  }
if ($done == 1) {
    Car::insert($model, $engine, $year, $registration, $mileage, $fueltype, $condition, $features, $description, $price);

    $success = 'Vehicle successfully added.';
}

  }
?>

<div class="container">
    <?php if (isset($errors)) {
        foreach ($errors as $error) { ?>
            <p><?= $error; ?></p>
    <?php }
    } else if (isset($success)) { ?>
        <p><?= $success; ?></p>
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

    <form name="addcar" method="post" action="" enctype="multipart/form-data">
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

        Image: <input type="file" name="image" id="image" />
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
</script>
