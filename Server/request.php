<?php

if (isset($_POST["img"])) {
    echo "************";
    $encodedimage = $_POST["img"];
    $decodedimage = base64_decode($encodedimage);
    $filename = $_POST["filename"];
    
    /*try {
        $myfile = fopen($_POST["filename"], "w");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    fwrite($myfile, $decodedimage);
    fclose($myfile);*/
    
    file_put_contents($filename, $decodedimage);
    //$decodedimage =base64_decode($encodedString);
    echo "Imagen enviada";
} else {
    $myfile2 = fopen("error.txt", "w");
    fwrite($myfile2, "No vino ninguna imagen en la petición.");
    fclose($myfile2);
}

