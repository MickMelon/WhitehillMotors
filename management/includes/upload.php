<?php
// Ensure that there are files being uploaded
if (isset($_FILES['imageUpload']) && count(array_filter($_FILES['imageUpload']['name'])) > 0) {
    echo "Total files: " . count(array_filter($_FILES['imageUpload']['name']));
    // Loop through each file
    for ($i = 0; $i < count(array_filter($_FILES['imageUpload']['name'])); $i++) {
        // Initialize errors array
        $errors = array();

        // Set variables
        $file_name = $_FILES['imageUpload']['name'][$i];
        $file_size = $_FILES['imageUpload']['size'][$i];
        $file_tmp = $_FILES['imageUpload']['tmp_name'][$i];
        $file_type = $_FILES['imageUpload']['type'][$i];

        echo 'Filename: ' . $file_name . '<br />';
        echo 'Size: ' . $file_size . '<br />';
        echo 'Type: ' . $file_type . '<br />';

        // Get the extension (jpg, png) from the file name
        $file_ext = strtolower(end(explode('.', $file_name)));

        // Create allowed extensions array
        $extensions = array("jpeg", "jpg", "png");

        // Check to see if the file extension matches any in the array
        if (!in_array($file_ext, $extensions)) {
            $errors[] = "File extension not allowed, please choose a JPEG or PNG file.";
        }

        // Make sure the file size is not larger than 2MB.
        if ($file_size > 2097152) {
            $errors[] = "File size cannot be larger than 2MB.";
        }

        // Check if there were any errors
        if (empty($errors)) {
            $directory = '../img/cars/' . $registration . '/';
            // If there is no directory for that car yet, create it
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Rename the file to be count plus extension type. e.g. 0.jpg or 1.png
            $temp = explode('.', $file_name);
            $newname = $i . '.' . end($temp);
            move_uploaded_file($file_tmp, $directory . $newname);
        } else {
            // print_r($errors);
        }
    }
}
