<?php

if (isset($_POST["data"])) {
    $datos = $_POST["data"];
} else {
    return "No se envio nada";
}

foreach ($datos as $file) {
    if (isset($file['img']) || isset($file['filename'])) {
        $encodedimage = $file['img'];
        $filename = $file['filename'];
    } else {
        return "Error with data";
    }
    try {
        $decodedimage = base64_decode($encodedimage);
        file_put_contents($filename, $decodedimage);
    } catch (Error $e) {
        return $e->getMessage();
    }
}
return "Imagenes guardadas";


