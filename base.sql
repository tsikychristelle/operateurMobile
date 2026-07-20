-- Active: 1784530400378@@127.0.0.1@3306
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
    idClientNumero INTEGER NOT NULL,
    idTypeOperation INTEGER NOT NULL,
    montant REAL NOT NULL,
    idEnvoyeur INTEGER,  -- Réfère probablement à l'ID d'un autre client ou clientNumero
    idRecepteur INTEGER, -- Réfère probablement à l'ID d'un autre client ou clientNumero
    FOREIGN KEY (idClientNumero) REFERENCES clientNumero(id),
    FOREIGN KEY (idTypeOperation) REFERENCES typeOperation(id)
);