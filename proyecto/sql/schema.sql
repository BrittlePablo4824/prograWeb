-- ============================================================
--  👻  Proyecto Final 👻 - PROGRAMACIÓN WEB
--  Base de Datos: Sistema de Gestión Académica
--  Autor: Pablo César Peña Padilla 
-- ============================================================

-- ============================================================
--                      TABLA: USERS
-- ============================================================
-- Aquí se almacenan TODOS los usuarios del sistema:
-- Administrador, Maestro y Estudiante.
-- El rol por defecto es "student".
-- Se agregan dos campos opcionales para gamificación:
-- logro_tiempo      → Entregó actividades a tiempo
-- logro_promedio    → Tiene promedio general alto
-- ============================================================

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','teacher','student') NOT NULL DEFAULT 'student',
  logro_tiempo TINYINT DEFAULT 0,
  logro_promedio TINYINT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
--                  TABLA: SUBJECTS (MATERIAS)
-- ============================================================

CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT,
  teacher_id INT NULL,
  FOREIGN KEY (teacher_id) REFERENCES users(id)
        ON DELETE SET NULL
);

-- ============================================================
--              TABLA: ENROLLMENTS (INSCRIPCIONES)
-- ============================================================

CREATE TABLE enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  subject_id INT NOT NULL,
  status ENUM('pending','approved','rejected') DEFAULT 'pending',
  requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  reviewed_at TIMESTAMP NULL,
  reviewer_id INT NULL,
  reason_rejection TEXT NULL,

  UNIQUE(student_id, subject_id),

  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
  FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================
--                TABLA: ACTIVITIES (TAREAS)
-- ============================================================

CREATE TABLE activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  description TEXT,
  due_date DATE,
  weight DECIMAL(5,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- ============================================================
--              TABLA: SUBMISSIONS (ENTREGAS)
-- ============================================================

CREATE TABLE submissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  activity_id INT NOT NULL,
  student_id INT NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  delivery_file VARCHAR(255),

  FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,

  UNIQUE(activity_id, student_id)  -- Una entrega por estudiante por actividad
);

-- ============================================================
--             TABLA: GRADES (CALIFICACIONES)
-- ============================================================

CREATE TABLE grades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  submission_id INT NOT NULL UNIQUE,
  grade_value DECIMAL(5,2),
  feedback TEXT,
  graded_by INT,
  graded_at TIMESTAMP NULL,

  FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE,
  FOREIGN KEY (graded_by) REFERENCES users(id) ON DELETE SET NULL
);
