# Sistema de Gestión de Prácticas Profesionales Supervisadas (SYSACAD)

El SYSACAD es una plataforma integral diseñada para simplificar y mejorar la gestión de las Prácticas Profesionales Supervisadas (PPS) de los alumnos de la universidad. Esta herramienta esencial beneficia tanto a los alumnos como a los tutores y responsables de la facultad al optimizar el proceso de solicitud, seguimiento y aprobación de las PPS.

## Características Principales

- **Interfaz Intuitiva:** Ofrece a los alumnos una manera rápida y sencilla de registrar solicitudes de inicio de PPS.
- **Comunicación Eficiente:** Facilita la interacción entre alumnos y responsables, agilizando la asignación de tutores.
- **Visualización de Docentes:** Proporciona información detallada sobre docentes disponibles para ser tutores, incluyendo disponibilidad y áreas de especialización.
- **Seguimiento Detallado:** Permite a los alumnos cargar planes de trabajo, seguimientos semanales e informes finales, revisados y aprobados por los tutores.

Además de su funcionalidad principal, el sitio web ofrece una página de inicio pública, permitiendo a cualquier visitante conocer a los docentes disponibles para ser tutores de PPS.

## Despliegue de la Aplicación Laravel

### Comandos Básicos para el Despliegue

Para desplegar una aplicación basada en Laravel, estos son algunos comandos básicos que puedes utilizar junto con Docker:

```bash
docker-compose up -d           # Inicia los contenedores de Docker en segundo plano.
docker exec -it id_contenedor php composer.phar install   # Instala las dependencias del proyecto.
docker exec -it id_contenedor php artisan key:generate    # Genera una nueva clave de aplicación.
docker exec -it id_contenedor php artisan config:cache     # Combina y almacena en caché archivos de configuración.
docker exec -it id_contenedor php artisan migrate          # Ejecuta migraciones de la base de datos.
docker exec -it id_contenedor php artisan db:seed          # Ejecuta los seeders de la base de datos.
docker exec -it id_contenedor php artisan serve            # Inicia el servidor de desarrollo de Laravel.
docker exec -it id_contenedor php artisan optimize         # Optimiza la aplicación para un mejor rendimiento.
```

Recuerda consultar la documentación oficial de Laravel para obtener más detalles sobre el despliegue de la aplicación.

## Configuraciones Importantes
Al desplegar tu aplicación Laravel, es esencial configurar adecuadamente ciertas variables en el entorno de producción para garantizar el correcto funcionamiento del sistema. Estas variables se encuentran en el archivo .env y contienen información sensible como contraseñas y claves de cifrado.

Ejemplo de Variables de Entorno

### Configuración de la Aplicación
APP_DEBUG=false
APP_ENV=production
APP_KEY=base64:key_generada_por_laravel
APP_LOCALE=es
APP_NAME=SYSACAD
APP_URL=http://localhost/

### Configuración de la Base de Datos
DB_CONNECTION=pgsql
DB_DATABASE=nombre_de_la_base_de_datos
DB_HOST=host_de_la_base_de_datos
DB_PASSWORD=contraseña_de_la_base_de_datos
DB_PORT=puerto_de_la_base_de_datos
DB_USERNAME=usuario_de_la_base_de_datos

### Otras Configuraciones (Correo, Logs, etc.)
FILESYSTEM_DISK=local
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@sysacad.com
MAIL_FROM_NAME=SYSACAD
MAIL_HOST=host_de_la_cuenta_de_correo
MAIL_MAILER=smtp
MAIL_PASSWORD=contraseña_de_la_cuenta_de_correo
MAIL_PORT=puerto_de_la_cuenta_de_correo
MAIL_USERNAME=usuario_de_la_cuenta_de_correo


Asegúrate de configurar estas variables de manera segura en tu servidor de producción y no exponerlas públicamente.