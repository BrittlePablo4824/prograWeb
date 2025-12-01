README — Sistema de Gestión Académica
👻  Proyecto Final 👻 – Programación Web

Autor: Pablo César Peña Padilla
Tecnologías: PHP, MySQL, HTML, CSS, Bootstrap

Descripción General

Este proyecto es un Sistema de Gestión Académica donde estudiantes, maestros y administradores pueden interactuar dentro de una sola plataforma.
El sistema permite gestionar materias, tareas, entregas, calificaciones, inscripciones y cuentas de usuario.

Está diseñado para ser simple, funcional y escalable, cumpliendo con los requisitos de un entorno académico real.

Objetivos del Proyecto

* Construir un sistema completo con roles (admin, teacher y student).
* Implementar módulos reales: materias, inscripciones, tareas, entregas, calificaciones, solicitudes.
* Usar PHP y MySQL aplicando buenas prácticas (sesiones, seguridad básica, hashing de contraseñas).
* Desarrollar un panel diferente para cada usuario según su rol.
* Practicar la creación de un diagrama EER, relaciones, y esquema SQL completo.

Características Principales

1. Módulo Estudiante

* Ver las materias en las que está inscrito.
* Solicitar inscripción a nuevas materias.
* Ver tareas asignadas por materia.
* Subir entregas en PDF u otros formatos.
* Consultar sus calificaciones.


2. Módulo Maestro

* Ver sus materias asignadas.
* Crear actividades/tareas.
* Revisar entregas de estudiantes.
* Calificar tareas y dejar retroalimentación.
* Administrar solicitudes de inscripción.


3. Módulo Administrador

* Crear, editar y eliminar usuarios.
* Crear y eliminar materias.
* Asignar maestros a materias.
* Supervisar el funcionamiento general.


4. Sistema de Autenticación

* Inicio de sesión para cualquier rol.
* Hash seguro con password_hash() para guardar contraseñas.
* Control de acceso usando sesiones.


5. Recuperación de Contraseña

* Incluye un flujo sencillo pero funcional:
* El usuario envía su correo.
* Si el correo existe, se redirige al formulario para actualizar contraseña.
* La contraseña se actualiza con hashing seguro.
* Mensaje final con botón para regresar al login.


Arquitectura del Proyecto:

proyecto/
│
├── backend/
│   ├── config/
│   │   └── db.php
│   ├── login.php
│   ├── logout.php
│   ├── admin/
│   │   ├── update_user.php
│   │   ├── delete_user.php
│   │   ├── subject_create.php
│   │   └── subject_delete.php
│   ├── teacher/
│   │   └── save_grade.php
│   ├── student/
│   │   └── entregar_actividad.php
│   └── password/
│       ├── recover_password.php
│       └── reset_password.php
│
├── frontend/
│   ├── login.html
│   ├── register.html
│   ├── dashboards/
│   │   ├── admin/
│   │   ├── teacher/
│   │   └── student/
│   └── password/
│       ├── recover_password.php
│       └── reset_password.php
│
└── sql/
    └── schema.sql


Base de Datos

Se utilizó un diseño relacional normalizado, implementado en MySQL Workbench.

Tablas principales:

* users
* subjects
* enrollments
* activities
* submissions
* grades


Relaciones clave:

* Un maestro puede impartir varias materias.
* Una materia tiene muchas actividades.
* Un estudiante puede inscribirse a varias materias.
* Una actividad tiene muchas entregas.
* Una entrega tiene una calificación.


Todas las relaciones están reflejadas en el archivo schema.sql.

Tecnologías Usadas:

* Tecnología	Uso
* PHP 8	Lógica del servidor y controladores
* MySQL	Base de datos relacional
* HTML5 / CSS3	Estructura y estilos
* Bootstrap	Estilos modernos y responsive
* Sessions de PHP	Manejo de autenticación
* MySQL Workbench	Modelo EER y diseño de BD


