/* CREACIÓN DE LA BASE DE DATOS */
CREATE DATABASE IF NOT EXISTS asaderosonline DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE asaderosonline;

/* CREACIÓN DE TABLAS */
CREATE TABLE IF NOT EXISTS Asaderos (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    lugar VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    descripcion VARCHAR(300) NOT NULL,
    precio INT NOT NULL,
    maxpersonas INT NOT NULL,
    creadoen TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizadoen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    contrasena VARCHAR(100) NOT NULL,
    telefono VARCHAR(9) NOT NULL,
    email VARCHAR(100) NOT NULL,
    admin BOOLEAN DEFAULT false,
    creadoen TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizadoen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Reservas (
    id INT NOT NULL AUTO_INCREMENT,
    idasadero INT NOT NULL,
    idusuario INT NOT NULL,
    creadoen TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizadoen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (idasadero) REFERENCES Asaderos(id),
    FOREIGN KEY (idusuario) REFERENCES Usuarios(id)
);

/* INSERCIÓN DE DATOS DE PRUEBA */

INSERT INTO Asaderos (nombre, lugar, fecha, descripcion, precio, maxpersonas) VALUES
('Asadero de prueba', 'Calle de prueba', '2023-05-05', 'Descripción de prueba 1', 10, 10),
('Asadero de prueba 2', 'Calle de prueba 2', '2023-05-05', 'Descripción de prueba 2', 10, 10),
('Asadero de prueba 3', 'Calle de prueba 3', '2023-05-05', 'Descripción de prueba 3', 10, 10),
('Asadero de prueba 4', 'Calle de prueba 4', '2023-05-05', 'Descripción de prueba 4', 10, 10),
('Asadero de prueba 5', 'Calle de prueba 5', '2023-05-05', 'Descripción de prueba 5', 10, 10),
('Asadero de prueba 6', 'Calle de prueba 6', '2023-05-05', 'Descripción de prueba 6', 10, 10);
