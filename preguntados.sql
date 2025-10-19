
CREATE DATABASE IF NOT EXISTS preguntados;
USE preguntados;

CREATE TABLE roles (
                       id_rol INT PRIMARY KEY AUTO_INCREMENT,
                       nombre_rol VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE usuario (
                         usuarioId INT PRIMARY KEY AUTO_INCREMENT,
                         nombre_completo VARCHAR(255) NOT NULL,
                         anio_nacimiento INT NOT NULL,
                         sexo ENUM('Masculino', 'Femenino', 'Prefiero no cargarlo') NOT NULL,
                         pais VARCHAR(100) NOT NULL,
                         ciudad VARCHAR(100) NOT NULL,
                         email VARCHAR(255) NOT NULL UNIQUE,
                         password VARCHAR(255) NOT NULL,
                         nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
                         foto_perfil VARCHAR(255) NULL,
                         cuenta_verificada BOOLEAN DEFAULT FALSE,
                         puntaje_total INT DEFAULT 0,
                         id_rol INT NOT NULL,
                         fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

INSERT INTO roles (nombre_rol) VALUES ('Jugador'), ('Editor'), ('Administrador');

INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, password, nombre_usuario, foto_perfil, cuenta_verificada, puntaje_total, id_rol)
VALUES
    ('Ana Martinez', 1998, 'Femenino', 'Argentina', 'La Plata', 'ana.martinez@email.com', '$2y$10$p1hN4iPHVZyVHaIVJTYeleQCnSmcFk8PHbhCDHnsF2fTlhkycObtW', 'Ana', 'imagenes/fotoPerfil.jpg', TRUE, 1250, 1);

INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, password, nombre_usuario, foto_perfil, cuenta_verificada, id_rol)
VALUES
    ('Carlos Rodriguez', 1985, 'Masculino', 'Argentina', 'San Justo', 'carlos.editor@juego.com', '$2y$10$p1hN4iPHVZyVHaIVJTYeleQCnSmcFk8PHbhCDHnsF2fTlhkycObtW', 'Carlos', 'imagenes/fotoPerfil.jpg', TRUE, 2);

INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, password, nombre_usuario, foto_perfil, cuenta_verificada, id_rol)
VALUES
    ('Sofia Lopez', 1990, 'Prefiero no cargarlo', 'Argentina', 'Ramos Mejía', 'sofia.admin@juego.com', '$2y$10$p1hN4iPHVZyVHaIVJTYeleQCnSmcFk8PHbhCDHnsF2fTlhkycObtW', 'Sofia', 'imagenes/fotoPerfil.jpg', TRUE, 3);