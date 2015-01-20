# ImgPHP

#Cliente

Un script hecho en PHP que revisa un directorio (el que se especifique en la variable $dir) por nuevos archivos que hayan sido guardados en el. El script almacena una fecha del último "chequeo" en un archivo .txt.

1. Revisa la lista de los archivos.
2. Compara la fecha de modificación/creación de cada archivo, y si es mayor a la última fecha de chequeo (es decir, no ha sido subido al server) se toma en cuenta.
3. Revisa que sea una extensión de archivo aceptada (por ahora, solo imagenes y pdfs -puede ser modificado en la función extAccepted.
4. Si cumple con esas dos condiciones, lo codifica en base64 con la función base64_encode y lo agrega al array junto con el nombre de archivo.
5. Envía los archivos a través de un POST hacia el servidor.

#Server

El archivo que está en el servidor se colocó en la carpeta Server, y corresponde a request.php

En este archivo revisamos que la información si haya sido envíada, y luego recorremos el arreglo de archivos codificados. Los decodificamos y creamos el archivo correctamente. Por obvias razones, es necesario que el usuario de apache tenga permisos para creación de archivos.
