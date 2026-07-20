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

            - operateurModel (Gaelle)
            - operateurPrefixModel (Gaelle)
            - statusModel (Gaelle)
            - typeOperationModel (Gaelle)
            - intervalMontantModel (Gaelle)
            - fraisTypeOperationModel
            - clientModel
            - clientNumeroModel
            - clientNumeroOperateurModel
            - clientNumeroSoldeModel
            - mouvementModel   

            - operateurModel
            - operateurPrefixModel
            - statusModel
            - typeOperationModel
            - intervalMontantModel
            - fraisTypeOperationModel(Christelle)(ok)
            - clientModel(Christelle)(ok)
            - clientNumeroModel(Christelle)(ok)
            - clientNumeroOperateurModel(Christelle)(ok)
            - clientNumeroSoldeModel(Christelle)(ok)
            - mouvementModel(Christelle)(ok)

        
        + controller
            - operateurController
            - operateurPrefixController
            - statusController
            - typeOperationController
            - intervalMontantController
            - fraisTypeOperationController(Christelle)
            - clientController(Christelle)
            - clientNumeroController(Christelle)
            - clientNumeroOperateurController(Christelle)
            - clientNumeroSoldeController(Christelle)
            - mouvementController(Christelle)
        
        + Vue
        view
        fonction
            => fonction qui relie un numero avec un operateur
            => fonction qui cherche un client en fonction de son numero
            => fonction qui creer un mouvement ( quand on creer un mouvement le solde de l'envoyeur et du recepteur change)