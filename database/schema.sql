
CREATE DATABASE gestion_hotel;

USE gestion_hotel;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
	password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin (username, email, password_hash)
VALUES (
    'abdo_admin',
    'ezzyky.a371@ucd.ac.ma',
    '$2y$12$VE1RCD6n0tEIHiVan3D0pupW2kFDPVSkaERyM3TYn9PrjhyeORMR6'
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
	nationality VARCHAR(60) NOT NULL,
    ville       VARCHAR(100) NULL,
    pays        VARCHAR(60)  NULL DEFAULT 'Maroc',
    adresse     VARCHAR(255) NULL,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE chambres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_chambre INT NOT NULL UNIQUE,
    type VARCHAR(50) NOT NULL,
    prix_par_nuit DECIMAL(10,2) NOT NULL,
    capacite INT NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'disponible',
    description TEXT NULL,
    ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
    CONSTRAINT chk_chambre_prix
        CHECK (prix_par_nuit > 0),

    CONSTRAINT chk_chambre_capacite
        CHECK (capacite > 0)
    
);


CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,

    client_id INT NOT NULL,
    room_id INT NOT NULL,

    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,

    nombre_personnes INT NOT NULL,
    prix_total DECIMAL(10,2) NOT NULL,

    status VARCHAR(30) NOT NULL DEFAULT 'en_attente',

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_reservation_client
        FOREIGN KEY (client_id)
        REFERENCES clients(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_reservation_chambre
        FOREIGN KEY (room_id)
        REFERENCES chambres(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT chk_reservation_dates
        CHECK (date_depart > date_arrivee),

    CONSTRAINT chk_reservation_personnes
        CHECK (nombre_personnes > 0),

    CONSTRAINT chk_reservation_prix
        CHECK (prix_total >= 0)
);

