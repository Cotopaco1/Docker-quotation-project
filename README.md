## Contexto - Context
Este proyecto es una conversion de otro proyecto a un entorno de desarrollo con docker , evitando los problemas con la instalación de dependencias en otras maquinas, tambien con el fin de practicar mis habilidades sobre Docker y docker-compose.
Si desea contexto sobre el el código del proyecto(licitacionesApp), diríjase a este archivo [README.md](/licitacionesApp/README.md)
---
This project is a conversion of another project to a development environment with Docker, avoiding issues with dependency installation on other machines, and also to practice my skills with Docker and docker-compose.
If you want context about the project code (licitacionesApp), refer to this file [README.md](/licitacionesApp/README.md).


## Guía de instalación en Español

### Requisitos para la instalación
1. Git instalado.
2. Windows: DockerDesktop instalado, Información de instalación en la [Web-Oficial de Docker windows install](https://docs.docker.com/desktop/setup/install/windows-install/)
3. Linux: DockerEngine y Docker-compose instalado, Información de la instalación en el [articulo oficial de instalacion para linux](https://docs.docker.com/desktop/setup/install/linux/)

### Pasos a seguir

1. Clonar el repositorio escribiendo en la terminal: `git clone https://github.com/Cotopaco1/Docker-quotation-project.git` , Esto creara una carpeta con el nombre **Docker-quotation-project** .
2. Ubicarse dentro de la carpeta recien creada: `cd ./Docker-quotation-project`
3. Crear las variables de entorno(.env) que utiliza Laravel y docker-compose: cambiar el nombre del archivo `/.env.example` a -> `/.env` y cambiar el archivo `/licitacionesApp/.env.example` a -> `/licitacionesApp/.env` .
    - Es necesario que tengan estos nombres por que asi docker-compose y laravel utilizaran las variables aqui escritas, eres libre de cambiarlas pero ten en cuenta que si cambias alguna del .env de la raiz, debes cambiar el .env del proyecto laravel 'licitacionesApp'
4. Ejecutar docker-compose: `docker-compose up -d `
4. Instalar dependencias: para este paso y los subsecuentes necesitamos ejecutar comandos dentro del contenedor del servidor, por lo cual haremos lo siguiente:
    1. `docker exec -it apache-web-server sh` Esto nos permitira ejecutar los siguientes comandos desde adentro del contenedor en la carpeta donde esta directamente el proyecto.
        - **Si tienes el error** : "the input device is not a tty. if you are using minttc try prefixing the command with 'winpty' " lo que debes hacer es agregar el prefijo winpty: `` winpty docker exec -it apache-web-server sh``
    2. `composer install `
    3. `npm install `
    4. `npm run build `
5. Ejecutar migraciones:   `php artisan migrate`
6. Últimas configuraciones: ejecutaremos el comando `php artisan app:initial-settings` comando para configurar usuario y contraseña, y el impuesto IVA que utilizará la aplicación para su funcionamiento.
7. Visualizar el proyecto: Abre tu navegador de preferencia y escribe en la url: `http://localhost/` , te pedirá el correo y la contraseña anteriormente configurada.

## Installation Guide in English

### Installation Requirements
1. Git installed.
2. Windows: DockerDesktop installed. Installation information is available on the [Official Docker Windows Install Page](https://docs.docker.com/desktop/setup/install/windows-install/).
3. Linux: DockerEngine and Docker-compose installed. Installation information is available on the [Official Linux Installation Article](https://docs.docker.com/desktop/setup/install/linux/).

### Steps to Follow

1. Clone the repository by typing in the terminal: `git clone https://github.com/Cotopaco1/Docker-quotation-project.git`. This will create a folder named **Docker-quotation-project**.
2. Navigate to the newly created folder: `cd ./Docker-quotation-project`.
3. Create the environment variables (.env) used by Laravel and Docker-compose: change the name of the file `/.env.example` to `/.env` and change the file `/licitacionesApp/.env.example` to `/licitacionesApp/.env`.
    - It is necessary that they have these names because Docker-compose and Laravel will use the variables written here. You are free to change them, but keep in mind that if you change any in the root `.env`, you must also change the `.env` in the Laravel project 'licitacionesApp'.
4. Run docker-compose: `docker-compose up -d`.
5. Install dependencies: For this step and the following ones, we need to execute commands inside the server container, so we will do the following:
    1. `docker exec -it apache-web-server sh` This will allow us to run the following commands from inside the container in the folder where the project is located.
        - **If you encounter the error**: "the input device is not a tty. If you are using mintty, try prefixing the command with 'winpty'". You should add the `winpty` prefix: `` winpty docker exec -it apache-web-server sh``.
    2. `composer install`
    3. `npm install`
    4. `npm run build`
6. Run migrations: `php artisan migrate`.
7. Final configurations: Run the command `php artisan app:initial-settings` to configure the username, password, and the VAT tax that the application will use for its operation.
8. View the project: Open your preferred browser and type in the URL: `http://localhost/`. It will ask for the email and password you previously configured.


## Skills Learned-Reinforced
- Docker, Docker-compose
- Images, Volumes, Containers, Dockerfile
- Services
- Docker commands
- linux commands and installation.