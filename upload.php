<?php
require '../pdf2text.php';
require '../import-processing.php';
require 'test/doc2txt.class.php';
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        ///echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        ///echo "File is not an image.";
        $uploadOk = 1;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    ///echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    ///echo "Sorry, your file is too large.";
    $uploadOk = 1;
}
// Allow certain file formats

if($imageFileType != "doc" && $imageFileType != "docx" ) {
    echo "Sorry, only doc and docx files are allowed";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        ///echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $docObj = new Doc2Txt($target_file);
        $txt = $docObj->convertToText();
		echo $txt;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>