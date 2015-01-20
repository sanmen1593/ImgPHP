<?php

function storeImage() {
    if (isset($_POST["img"])) {
        try {
            $encodedimage = $_POST["img"];
            $decodedimage = base64_decode($encodedimage);
            if(isset($_POST["filename"])) {
                $filename = $_POST["filename"];
            } else {
                return "Error filename";
            }
            file_put_contents($filename, $decodedimage);
        } catch (Error $e) {
            return $e->getMessage();
        }
        //$decodedimage =base64_decode($encodedString);
        return "Imagen guardada";
    } else {
        return "Error empty image";
    }
}

storeImage();
