DROP DATABASE IF EXISTS Apuntes;
CREATE DATABASE Apuntes;
USE Apuntes;
CREATE TABLE Usuarios (
	IdUsuario INT PRIMARY KEY AUTO_INCREMENT,
	Nombre VARCHAR(30) NOT NULL,
	Apellido1 VARCHAR(30) NOT NULL,
	Apellido2 VARCHAR(30) NULL,
	Password VARCHAR(34) NOT NULL,
	Nick VARCHAR(20) NOT NULL,
	Email VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE Tipo (
	IdTipo INT PRIMARY KEY,
	Nombre VARCHAR(12) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE Estudios (
	IdEstudios INT PRIMARY KEY,
	Nombre VARCHAR(12) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE Curso (
	IdCurso INT PRIMARY KEY
) ENGINE = InnoDB;

CREATE TABLE Asignatura (
	IdAsignatura INT PRIMARY KEY,
	Codigo VARCHAR(10) NOT NULL,
	Nombre VARCHAR(50) NOT NULL,
	Estudios INT NOT NULL,
	Curso INT NOT NULL,
	CONSTRAINT fk_estudios FOREIGN KEY (Estudios) REFERENCES Estudios(IdEstudios),
	CONSTRAINT fk_curso FOREIGN KEY (Curso) REFERENCES Curso(IdCurso)
) ENGINE = InnoDB;

CREATE TABLE Anio (
	IdAnio INT PRIMARY KEY,
	Anio CHAR(9)
) ENGINE = InnoDB;

CREATE TABLE Apuntes (
	IdApuntes INT PRIMARY KEY AUTO_INCREMENT,
	Titulo VARCHAR(50) NOT NULL,
	Usuarios INT,
	FechaSubida DATETIME DEFAULT CURRENT_TIMESTAMP,
	Tipo INT NOT NULL,
	Anio INT NOT NULL,
	Documento VARCHAR(50) NOT NULL,
	Asignatura INT NOT NULL,
	CONSTRAINT fk_usuario FOREIGN KEY (Usuarios) REFERENCES Usuarios(idUsuario),
	CONSTRAINT fk_tipo FOREIGN KEY (Tipo) REFERENCES Tipo(IdTipo),
	CONSTRAINT fk_anio FOREIGN KEY (Anio) REFERENCES Anio(IdAnio),
	CONSTRAINT fk_asignatura FOREIGN KEY (Asignatura) REFERENCES Asignatura(IdAsignatura)
) ENGINE = InnoDB;

CREATE TABLE Sesion (
	IdSession VARCHAR(32) NOT NULL PRIMARY KEY,
    IdUsuario INT NOT NULL,
    CONSTRAINT fk_sesion_usuario FOREIGN KEY (IdUsuario) REFERENCES Usuarios(IdUsuario)
)ENGINE = InnoDB;


INSERT INTO Estudios VALUES(0, 'Física');
INSERT INTO Estudios VALUES(1, 'Matemáticas');

INSERT INTO Tipo VALUES(0, 'Apuntes');
INSERT INTO Tipo VALUES(1, 'Examen');

INSERT INTO Curso VALUES(1);
INSERT INTO Curso VALUES(2);
INSERT INTO Curso VALUES(3);
INSERT INTO Curso VALUES(4);

--INSERT INTO Asignatura VALUES(0, 'G00', 'Métodos Físicos', 0, 1);
INSERT INTO `Asignatura` (`IdAsignatura`, `Codigo`, `Nombre`, `Estudios`, `Curso`) VALUES ('1', 'G51', 'Electricidad y magnetismo', '0', '2');
INSERT INTO `Asignatura` (`IdAsignatura`, `Codigo`, `Nombre`, `Estudios`, `Curso`) VALUES ('2', 'G53', 'Termodinámica', '0', '2');
INSERT INTO `Asignatura` (`IdAsignatura`, `Codigo`, `Nombre`, `Estudios`, `Curso`) VALUES ('3', 'G55', 'Física Cuántica y Estructura de la Materia I: Fundamentos de la Física Cuántica
', '0', '2');

INSERT INTO Anio VALUES(0, '2010/2011');
INSERT INTO Anio VALUES(1, '2011/2012');
INSERT INTO Anio VALUES(2, '2012/2013');
INSERT INTO Anio VALUES(3, '2013/2014');
INSERT INTO Anio VALUES(4, '2014/2015');
INSERT INTO Anio VALUES(5, '2015/2016');
INSERT INTO Anio VALUES(6, '2016/2017');

INSERT INTO `Usuarios` (`IdUsuario`, `Nombre`, `Apellido1`, `Apellido2`, `Password`, `Nick`, `Email`) VALUES (NULL, 'David', 'Iglesias', 'Sánchez', 'ooo', 'Pelu', 'davidiglesanchez@gmail.com');
INSERT INTO `Apuntes` (`IdApuntes`, `Titulo`, `Usuarios`, `FechaSubida`, `Tipo`, `Anio`, `Documento`, `Asignatura`) VALUES ('0', 'Cuando las cosas se ponen feas', '1', CURRENT_TIMESTAMP, '0', '4', 'cuando.pdf', '0');