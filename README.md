Portal de Eventos Comunitarios
Descripción
El Portal de Eventos Comunitarios es una plataforma diseñada para conectar a los miembros de una comunidad, permitiendo la participación en eventos locales. Este proyecto tiene como objetivo resolver la falta de un espacio centralizado donde las personas puedan informarse sobre eventos en su área, registrarse y fomentar la interacción comunitaria. La plataforma facilita la gestión y promoción de eventos, promoviendo la participación ciudadana y el fortalecimiento del tejido social.

Requisitos de Software
XAMPP: Herramienta para configurar un servidor local que incluye Apache, MySQL, PHP y Perl.
Visual Studio Code: Editor de código utilizado para el desarrollo del proyecto.
phpMyAdmin: Herramienta basada en web para la gestión de bases de datos MySQL.
PHP: Lenguaje de programación utilizado para el backend.
HTML: Lenguaje de marcado utilizado para estructurar el frontend.
CSS (Bootstrap): Framework utilizado para el diseño responsive de la interfaz de usuario.
JavaScript: Lenguaje de programación utilizado para añadir interactividad en el frontend.
Instalación y Configuración
XAMPP
Descargar la versión más reciente de XAMPP desde el sitio oficial.
Instalar XAMPP siguiendo las instrucciones del instalador.
Asegurarse de que Apache y MySQL estén habilitados en el panel de control de XAMPP.
Visual Studio Code
Descargar Visual Studio Code desde el sitio oficial.
Instalar extensiones recomendadas como:
PHP Intelephense
Live Server
Prettier para formateo de código
phpMyAdmin
Asegurarse de que MySQL esté activo en XAMPP.
Abrir phpMyAdmin en el navegador en la dirección: http://localhost/phpmyadmin.
Crear una nueva base de datos para el proyecto.
Configuración de Base de Datos
Importar el archivo SQL con la estructura de las tablas desde phpMyAdmin:
Ir a la opción "Importar" y seleccionar el archivo SQL del proyecto.
Arquitectura del Proyecto
Estructura de Carpetas y Archivos
assets/: Archivos estáticos como hojas de estilo CSS, iconos e imágenes.
css/: Estilos personalizados del proyecto utilizando Bootstrap.
icons/: Archivos de iconos utilizados en la interfaz.
images/: Imágenes del proyecto (logos, banners de eventos).
includes/: Archivos para la funcionalidad interna.
db.php: Gestión de la conexión con la base de datos.
templates/: Plantillas reutilizables para las páginas.
footer.php: Pie de página.
header.php: Encabezado.
Páginas PHP:
contacto.php, eventos.php, index.php: Páginas principales del sitio.
agregar_usuario.php, modificar_usuario.php, eliminar_usuario.php: Gestión de usuarios.
crear_evento.php, editar_evento.php, eliminar_evento.php: Gestión de eventos.
login.php, register.php: Autenticación de usuarios.
Procesos y lógica:
evento_process.php, login_process.php, register_process.php: Lógica del backend para cada funcionalidad.
Descripción de Tecnologías Utilizadas
1. XAMPP
Utilizado para crear un servidor local que permite ejecutar y probar el sitio web en un entorno de desarrollo antes de su despliegue. MySQL se utiliza para almacenar información sobre usuarios, eventos, mensajes, entre otros.

2. Visual Studio Code
Editor de código fuente que facilita el desarrollo eficiente del proyecto, con funciones avanzadas como autocompletado e integración con Git.

3. phpMyAdmin
Facilita la administración de la base de datos MySQL a través de una interfaz gráfica, permitiendo la creación y modificación de tablas y consultas sin necesidad de escribir SQL manualmente.

4. PHP
Maneja la lógica del backend, gestionando la interacción con la base de datos, las sesiones de usuario y el procesamiento de formularios, incluyendo la autenticación de usuarios y la gestión de eventos.

5. HTML
Estructura las páginas web, definiendo la disposición del contenido, como formularios de contacto, eventos y formularios de registro.

6. CSS (Bootstrap)
Bootstrap facilita la creación de interfaces responsivas, asegurando que el diseño se vea bien en distintos dispositivos (ordenadores, tabletas, móviles). Incluye componentes preconstruidos como formularios y botones.

7. JavaScript
Añade interactividad al frontend, como la validación de formularios y la gestión de eventos dinámicos en la interfaz.

Contribuciones
Se aceptan contribuciones al proyecto. Puedes realizar un fork del repositorio, crear una nueva rama con tus modificaciones y realizar un pull request para su revisión.

Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.
