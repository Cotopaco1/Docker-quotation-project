<p align="center"><img src="./public/assets/logo-app-500x500.svg" width="200" alt="Laravel Logo"></p>

## Acerca de licitacionesApp

LicitacionesApp es una aplicación diseñada para gestionar cotizaciones y controlar los productos cotizados junto con sus fichas técnicas. La aplicación permite guardar cotizaciones realizadas por terceros y generar nuevas cotizaciones utilizando los datos previamente guardados. De esta manera, podrás mantener una base de datos con los productos que ya has cotizado y generar cotizaciones futuras aplicando un porcentaje de ganancia personalizado.

## Funcionalidades

- Módulo de productos, creacion, edicion y eliminacion de productos.
- Módulo de proveedores, creacion, edicion y eliminacion de proveedores.
- Módulo de cotizaciones, descargar zip de una cotizacion que contiene:
    - Archivo en formato excel(.xlsx), con la cotizacion, la cotizacion tiene el siguiente formato:
        - Lista de todos los productos, cada uno con la información ingresada por el usuario, además tendra columnas extras las cuales la aplicacion calculará automáticamente.
        - Columnas calculadas automaticamente: Precion uniario con Iva, Total (precio unitaro con IVA * cantidad del producto), total con ganancias, porcentaje de ganancia.
        - Suma de la columna total y total con ganancias.
    - Carpeta agrupando las fichas tecnicas de los productos cotizados. 

## Tecnologías principales utilizadas

- **Vue.js 3**: Usado para el frontend y la creación de interfaces dinámicas.
- **Laravel**: Framework PHP utilizado para el backend y la gestión de la lógica del servidor.
- **Inertia.js**: Puente que conecta Vue.js con Laravel para una experiencia de página única (SPA) sin necesidad de usar una API REST completa.

## Guia instalacion

Una vez conectada la base de datos y realizado las migraciones entonces:
- Ejecutar el comando app:initial-settings
  Este comando:
- Insertara la informacion del impuesto IVA (19%) - Se aplicara a las cotizaciones.
- Pedirá un correo electronico para el administrador y una contraseña.
- Creará la carpeta temp en el siguiente directorio : `/storage/app/private/temp`
  Por ultimo:
- Instale las dependencias e inicie el servidor.

## PHP Settings

### Extensiones requeridas:

- `php_zip` (habilitada)
- `php_xml` (habilitada)
- `php_gd2` (habilitada; también funciona con `php_gd`)
- `php_iconv` (habilitada)
- `php_simplexml` (habilitada)
- `php_xmlreader` (habilitada)
- `php_zlib` (habilitada)
- `sqlite3` (habilitada)
- `pdo_sqlite` (habilitada)

Este proyecto fue desarrollado con PHP versión **8.3.7**.

## Condiciones de Uso

Este código está protegido bajo la licencia **"Todos los derechos reservados"**, lo que significa que no se permite su uso, distribución ni modificación sin el permiso explícito del autor. 

Si deseas usar este código para algún propósito, por favor, contacta conmigo a **sss.sergiosilvasanchez@gmail.com**.
