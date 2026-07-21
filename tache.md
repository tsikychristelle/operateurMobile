## V1 
- Base donnees 
    * creation table 
        + operateur(id, libelle)
        + operateurPrefix(id, idOperateur, prefix)
        + status(id, libelle)   ===> avec frais ou sans frais 
        + typeOperation( id, type)
        + intervalMontant( id, debut, fin)
        + fraisTypeOperation (id, idTypeOperation, idIntervalMontant, frais)
        + client (id, nom)
        + clientNumero(id, idClient, numero)
        + clientNumeroOperateur(id, idClient, idOperateur) ===> idOperateur inserer automatiquement en fonction du prefixe du numero du client
        + clientNumeroSolde( id, idClientNumero, solde)
        + mouvement( id, date(DateTime), idClientNumero, idTypeOperation, Montant, idEnvoyeur, idRecepteur)
           
        
        
    * fonction
        + Modele

            - operateurModel (Gaelle)(ok)
            - operateurPrefixModel (Gaelle)(ok)
            - statusModel (Gaelle)(ok)
            - typeOperationModel (Gaelle)(ok)
            - intervalMontantModel (Gaelle)(ok)
            - fraisTypeOperationModel(Christelle)(ok)
            - clientModel(Christelle)(ok)
            - clientNumeroModel(Christelle)(ok)
            - clientNumeroOperateurModel(Christelle)(ok)
            - clientNumeroSoldeModel(Christelle)(ok)
            - mouvementModel(Christelle)(ok)

        
        + controller
            - operateurController(Gaelle)(ok)
            - operateurPrefixController(Gaelle)(ok)
            - statusController(Gaelle)(ok)
            - typeOperationController(Gaelle)(ok)
            - intervalMontantController(Gaelle)(ok)
            - fraisTypeOperationController(Christelle)
            - clientController(Christelle)
            - clientNumeroController(Christelle)
            - clientNumeroOperateurController(Christelle)
            - clientNumeroSoldeController(Christelle)
            - mouvementController(Christelle)
        
        + Vue
        view
        fonction
            => fonction qui relie un numero avec un operateur (Gaelle)(ok)
            => fonction qui cherche un client en fonction de son numero
            => fonction qui creer un mouvement ( quand on creer un mouvement le solde de l'envoyeur et du recepteur change)

creation de table
    promotion (id, valeur)(ok)

Model
    promotiionModel (ok)

controller
    promotionController(ok)

# Allea 2
Epargne 
-Creation de la tablle epargne 
-Creation de la page epargne 
-C'est l'utlisateur qui choist sn epargne 
-Quand c'est un transfert quand l'user fat un transert et qu'il a un epargne donc le frais est en foncton du poourcentage de l'epargne 

