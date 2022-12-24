<?php
    $file = $_FILES['fileToUpload'];

    // Save the file to the desired location on the server's file system using the move_uploaded_file() function
    move_uploaded_file($file['tmp_name'], './uploads/Uplands.mcworld');

?>
<h1>Uploaded New World!</h1>
<style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
</style>
