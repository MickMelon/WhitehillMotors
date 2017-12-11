<?php
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
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
      } else {
        // print_r($errors);
      }
  }
