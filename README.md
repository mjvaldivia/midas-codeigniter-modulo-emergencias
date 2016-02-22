# emergencias

1.- Instalación.

1.1.- Ejecutar "git clone https://github.com/CarlosAyala/emergencias"
1.2.- Crear directorio media/ y dar permisos de escritura para el usuario apache.
1.3.- Crear host virtual

    <VirtualHost *:80>
       DocumentRoot "[path/to/system]"
       ServerName [url]

       # Variable que setea el entorno de trabajo
       # Si no se setea esta variable, 
       # debe modificarse el archivo index.php y cambiar la variable de entorno
       SetEnv ENVIRONMENT development

       <Directory "[path/to/system]">
           Options Indexes MultiViews FollowSymLinks
           AllowOverride All
           Order allow,deny
           Allow from all
       </Directory>

    </VirtualHost>
