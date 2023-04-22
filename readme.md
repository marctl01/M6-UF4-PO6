
DROP DATABASE encuestasdb;
CREATE DATABASE encuestasdb;

DROP TABLE tencuestas;
CREATE TABLE tencuestas(
	codencuesta INT NOT NULL AUTO_INCREMENT,
	textoencuesta  VARCHAR(50),
	votosopc1 int DEFAULT 0,
	votosopc2 int DEFAULT 0,
	votosopc3 int DEFAULT 0,
	opcion1 VARCHAR(25),
	opcion2 VARCHAR(25),
	opcion3 VARCHAR(25),
	CONSTRAINT PRIMARY KEY (idanuncio)
);

