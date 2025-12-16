-- Création de la base de données
CREATE DATABASE IF NOT EXISTS caramba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE caramba;

-- Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    photo_url VARCHAR(255) DEFAULT 'default-avatar.jpg',
    description TEXT,
    a_permis ENUM('Oui', 'Non') DEFAULT 'Non',
    type_permis VARCHAR(10),
    anciennete_compte VARCHAR(50),
    type_voiture VARCHAR(100),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertion de données de test
INSERT INTO users (username, nom, email, telephone, password, photo_url, description, a_permis, type_permis, anciennete_compte, type_voiture) 
VALUES 
('User#0001', 'Janne Doe', 'Janne_Doe@email.com', 'xx xx xx xx 17', '$2y$10$example_hashed_password', 'profile.jpg', 'Je suis Janne Doe et voici une description', 'Oui', 'B', '6 ans', 'Cytroen C3');

-- Table trajets
CREATE TABLE IF NOT EXISTS trajets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    depart VARCHAR(100) NOT NULL,
    arrivee VARCHAR(100) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    conducteur VARCHAR(100),
    date_trajet DATE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertion de trajets de test
INSERT INTO trajets (user_id, depart, arrivee, prix, conducteur, date_trajet) VALUES
(1, 'Paris', 'Toulouse', 45.00, 'Jean Daniel', '2024-12-01'),
(1, 'Toulouse', 'Paris', 65.00, 'Nicolas Dubois', '2024-12-05'),
(1, 'Bretagne', 'Brest', 35.00, 'Owen Strovoskÿ', '2024-12-10'),
(1, 'Marseille', 'Bordeaux', 80.00, 'Michelle Jäger', '2024-12-15'),
(1, 'Bordeaux', 'Lille', 125.00, 'Léo Gracieux', '2024-12-20'),
(1, 'Caen', 'Valence', 95.00, 'Mickaël Berlioz', '2024-12-25');

-- Table avis
CREATE TABLE IF NOT EXISTS avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trajet_id INT NOT NULL,
    evaluateur VARCHAR(100) NOT NULL,
    note INT CHECK (note >= 1 AND note <= 5),
    type_avis ENUM('recu', 'donne') NOT NULL,
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trajet_id) REFERENCES trajets(id) ON DELETE CASCADE
);

-- Insertion d'avis de test
INSERT INTO avis (user_id, trajet_id, evaluateur, note, type_avis, commentaire) VALUES
(1, 1, 'Véronique Martine', 5, 'recu', 'Excellent conducteur'),
(1, 2, 'Cédric Willams', 4, 'recu', 'Très bien'),
(1, 3, 'Mathieux Brant', 5, 'recu', 'Parfait'),
(1, 1, 'Nicolas Dubois', 4, 'donne', 'Bon passager'),
(1, 2, 'Owen Strovoskÿ', 5, 'donne', 'Très sympathique'),
(1, 4, 'Michelle Jäger', 5, 'donne', 'Recommandé'),
(1, 5, 'Léo Gracieux', 4, 'donne', 'Bien'),
(1, 6, 'Mickaël Berlioz', 5, 'donne', 'Excellent');

-- Table factures
CREATE TABLE IF NOT EXISTS factures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trajet_id INT NOT NULL,
    numero_facture VARCHAR(50) UNIQUE NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    statut ENUM('payee', 'en_attente', 'annulee') DEFAULT 'en_attente',
    date_facture DATE NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trajet_id) REFERENCES trajets(id) ON DELETE CASCADE
);

-- Insertion de factures de test
INSERT INTO factures (user_id, trajet_id, numero_facture, montant, statut, date_facture) VALUES
(1, 1, 'FACT-2024-001', 45.00, 'payee', '2024-12-01'),
(1, 2, 'FACT-2024-002', 65.00, 'payee', '2024-12-05'),
(1, 3, 'FACT-2024-003', 35.00, 'en_attente', '2024-12-10');