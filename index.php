<?php
require "PasswordProtectPDF.php";

if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    $password       =   $_POST['password'];
    $destFile       =   "upload/";
    $target_file    =   $destFile . basename($_FILES["protect-pdf"]["name"]);
    $name           =   $_FILES["protect-pdf"]["name"];
    $upload         =   move_uploaded_file($_FILES['protect-pdf']['tmp_name'], $target_file);
    if ($upload == '1') {
        try {
            $pdf = new PasswordProtectPDF($target_file, $password); // render the PDF inline (i.e. within browser where supported)
            $pdf->setTitle($name)->output('D', "Protected - " . $name);
        } catch (\Exception $e) {
            if ($e->getCode() == 267) {
                die('The compression on this file is not supported.');
            }
            die('There was an error generating the PDF.');
        }
        exit;
    }
}
?>
<html>

<body>
    <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        File: <input type="file" name="protect-pdf"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" name="submit" value="submit">
    </form>
</body>

</html>