<?php

$allsaved = true;
/* Una variable para saber si se guardaron todas las imagenes o no
  En caso de que no, se envia un status_code 500 y tienen que mandarse las imagenes de nuevo.
 */


if (isset($_POST["data"])) {
    $datos = $_POST["data"];
    foreach ($datos as $file) {
        var_dump(count($datos));
        if (isset($file['img']) && isset($file['filename'])) {
            $encodedimage = $file['img'];
            $filename = $file['filename'];
        } else {
            $allsaved = false;
        }
        try {
            $decodedimage = base64_decode($encodedimage);
            file_put_contents($filename, $decodedimage);
        } catch (Error $e) {
            $allsaved = false;
        }
    }
} else {
    $allsaved = false;
}

if ($allsaved == false) {
    http_response_code(500);
} else {
    http_response_code(200);
}