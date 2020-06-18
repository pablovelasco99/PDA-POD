# PDA-POD

## REQUISITOS
Para trabajar con este proyecto tendremos que convertir los archivos (pdf) que queramos transferir a la base de datos en archivos legibles para este programa (csv). Para esto utilizaremos los siguientes enlaces:
1. Para los archivos PDA utilizaremos la siguiente página: [Convertio](URL "https://convertio.co/es/")
2. Para los archivos POD utilizaremos la siguiente página: [Aconvert](URL "https://www.aconvert.com/pdf/")

El uso de dos páginas diferentes para la transformación de estos archivos se realiza debido a que la página [Convertio](URL "https://convertio.co/es/") funciona perfectamente cuando son archivos pequeños, con pocas tablas. Mientras que [Aconvert](URL "https://www.aconvert.com/pdf/") funciona perfectamente con archivos más grandes, con una cantidad de tablas más elevada.

Otro requisito que hay que cumplir es tener instalado PHP (si no lo tienes instalado puedes descargarlo en [PHP](URL "https://www.php.net/downloads.php") y XAMPP u otra aplicación que nos permita crear un servidor propio en nuestro equipo (si no lo tienes instalado puedes descargarlo en [XAMPP](URL "https://www.apachefriends.org/es/download.html").

## PUESTA EN MARCHA
Para poder utilizar esta programa tendremos que seguir los siguientes pasos:
1. Descargar y extraer este proyecto.
2. Iniciar el panel de control de XAMPP o de la aplicación que estés usando (en caso de usar XAMPP debemos de iniciar APACHE y MYSQL)
3. (Opcional) Si estás trabajando sobre un escritorio remoto puedes transferir tus archivos a ese equipo mediante SFTP. Una aplicación para esto puede ser [FILEZILLA](URL "https://filezilla-project.org/download.php?type=client").
4. Introducimos los archivos a transfeerir en sus respectivas carpetas. Para los archivos PDA tendremos la carpeta **Files/PDA** y para los archivos POD la carpeta **Files/POD**.
5. Crear la base de datos. Para ello tendremos que ir en nuestro navegador a `localhost/phpmyadmin`, crear una base de datos e importar el archivo .sql que se encuentra en **DB/TABLAS_correcto**.
6. Lanzamos nuestro programa escribiendo en nuestro navegador `localhost/ubicacion de tu archivo`. Automáticamente el programa extraerá la información de los archivos y la transferirá a la base de datos.
7. (Opcional) Si deseamos ver el resultado tendremos que ir a `localhost/phpmyadmin` y navegar por las tablas que tenemos creadas.

## EXPLICACIÓN DE FUNCIONAMIENTO
El programa se divide en 4 carpetas y 1 archivo **index.php**.
1. Carpeta **DB**: Aquí encontramos los archios necesarios para la creación de tablas y conexión con la base de datos.
2. Carpeta **FILES**: Esta a su vez se divide en dos sub-carpetas: PDA y POD, cada una para sus respectivos archivos.
3. Carpeta **FUNCTIONS**: En esta carpeta encontramos el archivo **functions.php**, el cual se encarga de extraer toda la información de los archivos mediante diferentes métodos de selección, que serán explicacos a continuación:
    * 
