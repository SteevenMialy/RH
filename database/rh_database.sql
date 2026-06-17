-- Activation des clés étrangères pour garantir l'intégrité des données
PRAGMA foreign_keys = ON;

-- Table 1 : Produit (Désignation, Prix, Quantité en stock)
CREATE TABLE produit (
    id_produit INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    prix REAL NOT NULL,
    quantite_stock INTEGER NOT NULL
);

-- Table 2 : Caisse
CREATE TABLE caisse (
    id_caisse INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_caisse TEXT NOT NULL
);

-- Table 3 : Achat (Fait le lien entre un produit, une caisse et gère la quantité achetée)
-- Note : Un ID ou numéro d'achat/ticket permettra de regrouper les articles d'un même client
CREATE TABLE achat (
    id_achat INTEGER PRIMARY KEY AUTOINCREMENT,
    id_ticket INTEGER NOT NULL, -- Pour regrouper les achats d'un même client (clôture achat)
    id_caisse INTEGER NOT NULL,
    id_produit INTEGER NOT NULL,
    quantite_achetee INTEGER NOT NULL,
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_caisse) REFERENCES caisse(id_caisse),
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
);