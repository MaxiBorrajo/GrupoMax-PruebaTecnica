# GrupoMax-Prueba Tecnica

Proyecto desarrollado como parte de una prueba técnica full stack de grupo max. Implementa una aplicación web utilizando PHP en el backend y Vue en el frontend.

## Tabla de Contenidos

1. [Instalación](#instalación)
2. [Uso](#uso)
3. [Configuración](#configuración)
4. [Uso](#uso)
5. [Endpoints](#endpoints)
6. [Testing](#testing)

## Instalación

Para utilizar este proyecto, debes tener instaladas las últimas versiones de PHP, Node.js, Composer, MySQL Server y Git en tu dispositivo.

```bash
git clone https://github.com/MaxiBorrajo/GrupoMax-PruebaTecnica.git
cd PruebaTecnica-Backend
composer install
cd ..
cd PruebaTecnica-Frontend
npm install
```
## Configuración y uso

En la carpeta PruebaTecnica-Backend, crea los archivos .env y .env.testing. En ambos, coloca las siguientes variables de entorno con las configuraciones pertinentes para el servidor local:
```dotenv
#Ejemplo de variables
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tuproyecto
DB_USERNAME=root
DB_PASSWORD=secret
```
`DB_DATABASE` debe ser diferente en cada archivo, y ambas bases de datos deben crearse dentro del entorno local.

Luego, para configurar el servicio de envío de correos, se necesitan las siguientes variables:

```dotenv
#Ejemplo de variables
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
Finalmente, en la carpeta `PruebaTecnica-Frontend`, crea un archivo .env con lo siguiente:
```dotenv
VITE_URL_SERVICE=http://127.0.0.1:8000
```
Esto permitirá que el frontend consuma la API montada en el entorno local.

## Uso
Una vez configurado e instalado todo, en la carpeta `PruebaTecnica-Backend`, ejecuta los siguientes comandos en la consola:
```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

Luego, en la carpeta `PruebaTecnica-Frontend`:
```bash
npm run dev
```
De esta manera, el proyecto estará disponible para su uso en el frontend (http://localhost:5137).

Usuario de prueba:
- Email: example@example.com
- Contraseña: password1234$

## Endpoints
Usando algún servicio que permita realizar peticiones HTTP, como Postman o ThunderClient :
<br>
<br>

- **Método HTTP:** GET
- **Ruta:** `/api/users`
- **Descripcion:** Devuelve todos los usuarios
- **Headers:** Authorization: Bearer "token de autorización"
- **Parámetros de Solicitud:**
  - keyword (string, opcional): Palabra clave para buscar usuarios, puede ser un nombre, apellido o por email
  - sort (string, requerido si hay un parametro order): Valor por el cual ordenar a los usuarios, puede ser por nombre, apellido o por email
  - order (string, requerido si hay un parametro sort): 'asc' si se quiere ordenar de forma ascendente, 'desc' de forma descendente
  - page (number, default igual a 1): Para poder paginar entre usuarios
  - limit (number, default igual a 20): Cantidad usuarios por pagina
<br>
<br>

- **Método HTTP:** POST
- **Ruta:** `/api/users`
- **Descripcion:** Crear un usuario nuevo y obtiene un token de autorización
- **Cuerpo de solicitud**
  - first_name (string, requerido)
  - last_name (string, requerido)
  - email (string, requerido)
  - password (string, requerido)
<br>
<br>

- **Método HTTP:** POST
- **Ruta:** `/api/users/login`
- **Descripcion:** Para iniciar sesión y obtener un token de autorización
- **Cuerpo de solicitud**
  - email (string, requerido)
  - password (string, requerido)
<br>
<br>

- **Método HTTP:** PUT
- **Ruta:** `/api/users`
- **Descripcion:** Actualiza la información del usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
- **Cuerpo de solicitud**
  - first_name (string, opcional)
  - last_name (string, opcional)
  - email (string, opcional)
<br>
<br>

- **Método HTTP:** GET
- **Ruta:** `/api/users/current`
- **Descripcion:** Obtiene información del usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
<br>
<br>

- **Método HTTP:** POST
- **Ruta:** `/api/users/forgotPassword`
- **Descripcion:** Envía un correo electrónico con un enlace para restablecer la contraseña
- **Cuerpo de solicitud**
  - email (string, requerido)
 <br>
<br>

- **Método HTTP:** POST
- **Ruta:** `/api/users/resetPassword`
- **Descripcion:** Restablece la contraseña del usuario
- **Cuerpo de solicitud**
  - password (string, requerido)
  - confirm_password (string, requerido)
  - token (string, requerido) (Se obtiene del mail)
 <br>
<br>

- **Método HTTP:** DELETE
- **Ruta:** `/api/users/logout`
- **Descripcion:** Cierra la sesión del usuario
- **Headers:** Authorization: Bearer "token de autorización"
<br>
<br>

- **Método HTTP:** DELETE
- **Ruta:** `/api/users`
- **Descripcion:** Elimina el usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
<br>
<br>

- **Método HTTP:** GET
- **Ruta:** `/api/clients`
- **Descripcion:** Devuelve todos los clientes asociados al usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
- **Parámetros de Solicitud:**
  - keyword (string, opcional): Palabra clave para buscar usuarios, puede ser un nombre, apellido, email o numero de telefono
  - sort (string, requerido si hay un parametro order): Valor por el cual ordenar a los usuarios, puede ser por first_name, last_name,
    email, age, phone_number o status
  - order (string, requerido si hay un parametro sort): 'asc' si se quiere ordenar de forma ascendente, 'desc' de forma descendente
  - page (number, default igual a 1): Para poder paginar entre usuarios
  - limit (number, default igual a 20): Cantidad usuarios por pagina
<br>
<br>

- **Método HTTP:** POST
- **Ruta:** `/api/clients`
- **Descripcion:** Crea un nuevo cliente asociado al usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
- **Cuerpo de solicitud**
  - first_name (string, requerido)
  - last_name (string, requerido)
  - email (string, requerido)
  - age (number, requerido)
  - phone_number (string, requerido)
  - status (`ACTIVE` o `INACTIVE`, requerido)
<br>
<br>

- **Método HTTP:** PUT
- **Ruta:** `/api/clients/:idCliente`
- **Descripcion:** Actualiza la información del cliente con el ID dado, solo si está asociado al usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
- **Cuerpo de solicitud**
  - first_name (string, opcional)
  - last_name (string, opcional)
  - email (string, opcional)
  - age (number, opcional)
  - phone_number (string, opcional)
  - status (`ACTIVE` o `INACTIVE`, opcional)
<br>
<br>

- **Método HTTP:** GET
- **Ruta:** `/api/clients/:idCliente`
- **Descripcion:** Obtiene información del cliente con el ID dado, solo si está asociado al usuario actual
- **Headers:** Authorization: Bearer "token de autorización"
<br>
<br>

- **Método HTTP:** DELETE
- **Ruta:** `/api/clients/:idCliente`
- **Descripcion:** Elimina el cliente con el ID dado, solo si está asociado al usuario actual
- **Headers:** Authorization: Bearer "token de autorización"

## Testing
En caso de querer testear la aplicación, pararse sobre `PruebaTecnica-Backend` y ejecutar:
```bash
php artisan test
```
