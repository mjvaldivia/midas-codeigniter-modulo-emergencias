# emergencias

1.- Requerimientos.

#

2.- Instalación.

2.1.- Ejecutar "git clone https://github.com/CarlosAyala/emergencias"

2.2.- Crear directorio media/ y dar permisos de escritura para el usuario de apache.

2.3.- Crear host virtual y agregar url a archivo local hosts

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
