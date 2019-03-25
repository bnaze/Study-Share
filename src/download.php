<?php
    //Uses request for file so nthe server are returned in the $_GET array
    $file = $_GET['file'];
    //Returns the file name, which is at the end of the path name
    $fileName = basename($_GET['file']);

    //If the files exist it opens the file manages so you can download it onto your local machine
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"${fileName}");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
?>