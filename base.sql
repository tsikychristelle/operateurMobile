-- Active: 1784538205105@@127.0.0.1@3306
-- Activer le support des clés étrangères (obligatoire sous SQLite)
PRAGMA foreign_keys = ON;

-- 1. Tables principales (sans dépendances)
CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE status (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL -- ex: 'avec frais' ou 'sans frais'
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

-- 2. Tables avec dépendances (Clés étrangères)
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
    idEnvoyeur INTEGER,  -- Réfère probablement à l'ID d'un autre client ou clientNumero
    idRecepteur INTEGER, -- Réfère probablement à l'ID d'un autre client ou clientNumero
    FOREIGN KEY (idTypeOperation) REFERENCES typeOperation(id),
    FOREIGN KEY (idEnvoyeur) REFERENCES clientNumero(id),
    FOREIGN KEY (idRecepteur) REFERENCES clientNumero(id)
);


INSERT INTO operateur (libelle) VALUES 
('Orange'),
('MTN'),
('Moov'),
('Autres');

-- Exemple pour Orange (supposons que son id = 1)
INSERT INTO operateurPrefix (idOperateur, prefix) VALUES 
(1, '033'),
(1, '037'),
(1, '055'),  -- selon les préfixes réels de votre pays
(2, '077'),  -- MTN par exemple
(2, '078');
INSERT INTO "typeOperation" (type) VALUES 
('Depot'),
('Retrait'),
('Transfert');

-- 1. Insertion des clients
INSERT INTO client (nom) VALUES 
('Rakoto'),
('Rasoa'),
('Andry'),
('Mialy'),
('Kanto');

-- 2. Insertion des numéros associés (034 pour Telma, 033 pour Airtel)
-- L'idClient correspond à l'ID généré automatiquement dans la table client
INSERT INTO clientNumero (idClient, numero) VALUES 
(1, '0341234567'), -- Numéro Telma pour Rakoto (id = 1)
(1, '0331122233'), -- Deuxième numéro (Airtel) pour Rakoto
(2, '0349876543'), -- Numéro Telma pour Rasoa (id = 2)
(3, '0334455566'), -- Numéro Airtel pour Andry (id = 3)
(4, '0345566677'), -- Numéro Telma pour Mialy (id = 4)
(5, '0337788899'); -- Numéro Airtel pour Kanto (id = 5)

INSERT INTO clientNumeroSolde (idClientNumero, solde) VALUES 
(1, 50000.0),   -- Solde pour le numéro Telma de Rakoto (idClientNumero = 1)
(2, 1500.50),   -- Solde pour le numéro Airtel de Rakoto (idClientNumero = 2)
(3, 120000.0),  -- Solde pour le numéro Telma de Rasoa (idClientNumero = 3)
(4, 0.0),       -- Solde pour le numéro Airtel de Andry (idClientNumero = 4, compte vide)
(5, 85000.0),   -- Solde pour le numéro Telma de Mialy (idClientNumero = 5)
(6, 350000.0);  -- Solde pour le numéro Airtel de Kanto (idClientNumero = 6)

-- 1. Insertion des tranches de montants (intervalMontant)
-- Les IDs (1, 2, 3, 4) vont être générés automatiquement dans cet ordre
INSERT INTO intervalMontant (debut, fin) VALUES 
(100.0, 5000.0),     -- Tranche 1 : de 100 à 5 000 Ar
(5001.0, 20000.0),   -- Tranche 2 : de 5 001 à 20 000 Ar
(20001.0, 100000.0), -- Tranche 3 : de 20 001 à 100 000 Ar
(100001.0, 500000.0);-- Tranche 4 : de 100 001 à 500 000 Ar

-- 2. Insertion des frais associés (fraisTypeOperation)
-- On lie chaque type d'opération à un intervalle avec un montant de frais fixe
INSERT INTO fraisTypeOperation (idTypeOperation, idIntervalMontant, frais) VALUES 
-- Tarifs pour le Type d'opération 2 (Ex: Retrait)
(2, 1, 150.0),   -- Tranche 1 : 150 Ar de frais
(2, 2, 400.0),   -- Tranche 2 : 400 Ar de frais
(2, 3, 1200.0),  -- Tranche 3 : 1 200 Ar de frais
(2, 4, 3500.0),  -- Tranche 4 : 3 500 Ar de frais
(3, 2, 300.0),   -- Tranche 2 : 300 Ar de frais
(3, 3, 900.0),   -- Tranche 3 : 900 Ar de frais
(3, 4, 2800.0);  -- Tranche 4 : 2 800 Ar de frais

INSERT INTO clientNumeroOperateur (idClientNumero, idOperateur) VALUES 
(1, 4), -- 0341234567 -> Autres (opérateur non défini dans les préfixes)
(2, 1), -- 0331122233 -> Orange (préfixe 033)
(3, 4), -- 0349876543 -> Autres
(4, 1), -- 0334455566 -> Orange (préfixe 033)
(5, 4), -- 0345566677 -> Autres
(6, 1); -- 0337788899 -> Orange (préfixe 033)
CREATE TRIGGER after_client_numero_insert
AFTER INSERT ON clientNumero
BEGIN
    INSERT INTO clientNumeroOperateur (idClientNumero, idOperateur)
    VALUES (
        NEW.id,
        COALESCE(
            (SELECT idOperateur FROM operateurPrefix WHERE prefix = SUBSTR(NEW.numero, 1, 3) LIMIT 1),
            4 -- ID de l'opérateur 'Autres' par défaut
        )
    );
END;