DROP DATABASE IF EXISTS langlebien;
CREATE DATABASE langlebien CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE langlebien;

CREATE TABLE users (
    users_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR (100) UNIQUE NOT NULL,
    username VARCHAR (100) UNIQUE NOT NULL,
    password VARCHAR (255) NOT NULL
) ENGINE = INNODB;

CREATE TABLE categories (
    categories_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR (100) NOT NULL
) ENGINE = INNODB;

CREATE TABLE offers (
    offers_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    description TEXT NOT NULL,
    price FLOAT NOT NULL,
    category_id INT NOT NULL,
    author_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(categories_id),
    FOREIGN KEY (author_id) REFERENCES users(users_id)
) ENGINE = INNODB;

INSERT INTO categories (label) VALUES
    ('Vacances'),
    ('Emploi'),
    ('Véhicules'),
    ('Immobilier'),
    ('Mode'),
    ('Maison'),
    ('Multimédia'),
    ('Loisirs'),
    ('Animaux'),
    ('Matériel Professionnel'),
    ('Services'),
    ('Divers');
