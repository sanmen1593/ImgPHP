<?php

//require 'index.php';
include 'Requests-1.6.0/library/Requests.php'; //Incluir libreria de request para hacer peticiones
Requests::register_autoloader(); //Para que funcione la clase Request

date_default_timezone_set('America/Bogota');

function checkimages() {
    /* Chequea que haya imagenes en el directorio $dir
     * Escanea todos los archivos que hay en el directorio, y luego toma
     * aquellos cuya fecha de modificación/creación sea mayor a la ultima
     * fecha de chequeo (lastcheck.txt). Crea un array con las imagenes
     * convertidas. */
    $dir = "../files";
    $files = scandir($dir);
    $imgfiles = array();
    foreach ($files as $file) {
        if (extAccepted($file)) {
            if (date("F d Y H:i:s.", filemtime($dir . "/" . $file)) > getLastCheck()) {
                $fileconverted = convertImages($dir . '/' . $file);
                $imgfiles[] = array('img' => $fileconverted, 'filename' => $file);
            }
        }
    }
    return $imgfiles;
}

function extAccepted($file) {
    //extensiones aceptadas para ser enviadas
    if (pathinfo($file)['extension'] == 'jpg' || pathinfo($file)['extension'] == 'png' || pathinfo($file)['extension'] == 'gif' || pathinfo($file)['extension'] == 'pdf') {
        return true;
    } else {
        return false;
    }
}

function setLastCheck() {
    //Fijar la hora en que se chequeo por archivos nuevos por ultima vez
    $lastcheck = date("F d Y H:i:s.");
    $lastcheckfile = fopen("lastcheck.txt", "w") or die("Unable to open file!");
    fwrite($lastcheckfile, $lastcheck);
    fclose($lastcheckfile);
}

function getLastCheck() {
    //Recibir la hora en que se chequeo por archivos nuevos por ultima vez
    $openfile = fopen('lastcheck.txt', 'r') or die("Unable to open file!");
    $stringdate = fread($openfile, filesize('lastcheck.txt'));
    $date = strtotime($stringdate);
    $lastcheckread = date('F d Y H:i:s', $date);
    return $lastcheckread;
}

function convertImages($file) {
    //Convertir imagen en una byte array.
    $imgtoconvert = file_get_contents($file);
    $imgbase64 = base64_encode($imgtoconvert);
    return $imgbase64;
}

function sendToServer() {
    $images = checkimages(); //Recibimos un array con los archivos en base64 que van a ser enviados al server
    if ($images != null) {
        $data = $images;
        try {
            $response = Requests::post('http://104.131.74.66/request/request.php', array(), array('data' => $data));
        } catch (Error $e) {
            return $e->getMessage();
        }
        if ($response->success) {
            echo $response->status_code;
            echo $response->body;
            setLastCheck();
        } else {
            sendToServer();
        }
    }
}

sendToServer();
