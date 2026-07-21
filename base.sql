-- Activer le support des clés étrangères
PRAGMA foreign_keys = ON;

-- Clean-up (si nécessaire)
DROP TRIGGER IF EXISTS after_client_numero_insert;
DROP TABLE IF EXISTS mouvement;
DROP TABLE IF EXISTS clientNumeroSolde;
DROP TABLE IF EXISTS clientNumeroOperateur;
DROP TABLE IF EXISTS clientNumero;
DROP TABLE IF EXISTS fraisTypeOperation;
DROP TABLE IF EXISTS operateurPrefix;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS intervalMontant;
DROP TABLE IF EXISTS typeOperation;
DROP TABLE IF EXISTS status;
DROP TABLE IF EXISTS operateur;

-- 1. Tables principales
CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE status (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE typeOperation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT NOT NULL
);

CREATE TABLE intervalMontant (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    debut REAL NOT NULL,
    fin REAL NOT NULL
);

CREATE TABLE client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL
);

-- 2. Tables avec dépendances
CREATE TABLE operateurPrefix (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idOperateur INTEGER NOT NULL,
    prefix TEXT NOT NULL,
    FOREIGN KEY (idOperateur) REFERENCES operateur(id) ON DELETE CASCADE
);

CREATE TABLE fraisTypeOperation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idTypeOperation INTEGER NOT NULL,
    idIntervalMontant INTEGER NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY (idTypeOperation) REFERENCES typeOperation(id) ON DELETE CASCADE,
    FOREIGN KEY (idIntervalMontant) REFERENCES intervalMontant(id) ON DELETE CASCADE
);

CREATE TABLE clientNumero (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idClient INTEGER NOT NULL,
    numero TEXT NOT NULL UNIQUE,
    FOREIGN KEY (idClient) REFERENCES client(id) ON DELETE CASCADE
);

CREATE TABLE clientNumeroOperateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idClientNumero INTEGER NOT NULL,
    idOperateur INTEGER NOT NULL,
    FOREIGN KEY (idClientNumero) REFERENCES clientNumero(id) ON DELETE CASCADE,
    FOREIGN KEY (idOperateur) REFERENCES operateur(id) ON DELETE CASCADE
);

CREATE TABLE clientNumeroSolde (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idClientNumero INTEGER NOT NULL,
    solde REAL DEFAULT 0.0,
    FOREIGN KEY (idClientNumero) REFERENCES clientNumero(id) ON DELETE CASCADE
);

CREATE TABLE mouvement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    idTypeOperation INTEGER NOT NULL,
    montant REAL NOT NULL,
    idEnvoyeur INTEGER,
    idRecepteur INTEGER,
    FOREIGN KEY (idTypeOperation) REFERENCES typeOperation(id),
    FOREIGN KEY (idEnvoyeur) REFERENCES clientNumero(id),
    FOREIGN KEY (idRecepteur) REFERENCES clientNumero(id)
);

CREATE TABLE promoton (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    valeur DECIMAL(2,5)
)

-- 3. Le Trigger Corrigé
CREATE TRIGGER after_client_numero_insert
AFTER INSERT ON clientNumero
FOR EACH ROW
BEGIN
    INSERT INTO clientNumeroOperateur (idClientNumero, idOperateur)
    SELECT 
        NEW.id,
        idOperateur
    FROM operateurPrefix
    WHERE prefix = SUBSTR(TRIM(NEW.numero), 1, 3)
    LIMIT 1;
END;

-- -------------------------------------------------------------
-- INSERTIONS DES DONNÉES
-- -------------------------------------------------------------

-- Opérateurs (Génère IDs : 1 = Orange, 2 = Airtel, 3 = Yas)
INSERT INTO operateur (libelle) VALUES 
('Orange'),
('Airtel'),
('Yas');

-- Préfixes avec les BONS IDs de la table operateur (1, 2, 3)
INSERT INTO operateurPrefix (idOperateur, prefix) VALUES 
(1, '032'),
(1, '037'),
(2, '033'),
(3, '034'),
(3, '038');

INSERT INTO typeOperation (type) VALUES 
('Depot'),
('Retrait'),
('Transfert');

-- Clients (Génère IDs : 1 à 5)
INSERT INTO client (nom) VALUES 
('Rakoto'),
('Rasoa'),
('Andry'),
('Mialy'),
('Kanto');

-- Numéros (Rattachés aux VRAIS idClient : 1 à 5)
-- Le TRIGGER va automatiquement remplir clientNumeroOperateur ici !
INSERT INTO clientNumero (idClient, numero) VALUES 
(1, '0341234567'), -- Telma/Yas (id 1)
(1, '0331122233'), -- Airtel (id 2)
(2, '0349876543'), -- Telma/Yas (id 3)
(3, '0334455566'), -- Airtel (id 4)
(4, '0345566778'), -- Telma/Yas (id 5)
(5, '0337788899'); -- Airtel (id 6)

-- Soldes rattachés aux VRAIS idClientNumero (1 à 6)
INSERT INTO clientNumeroSolde (idClientNumero, solde) VALUES 
(1, 50000.0),
(2, 1500.50),
(3, 120000.0),
(4, 0.0),
(5, 85000.0),
(6, 350000.0);

-- Intervals & Frais
INSERT INTO intervalMontant (debut, fin) VALUES 
(100.0, 5000.0),     -- ID 1
(5001.0, 20000.0),   -- ID 2
(20001.0, 100000.0), -- ID 3
(100001.0, 500000.0);-- ID 4

INSERT INTO fraisTypeOperation (idTypeOperation, idIntervalMontant, frais) VALUES 
(2, 1, 150.0),
(2, 2, 400.0),
(2, 3, 1200.0),
(2, 4, 3500.0),
(3, 2, 300.0),
(3, 3, 900.0),
(3, 4, 2800.0);