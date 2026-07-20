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
            - clientNumeroOperateurModel(Christelle)
            - clientNumeroSoldeModel(Christelle)
            - mouvementModel(Christelle)

        
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
            => fonction qui relie un numero avec un operateur
            => fonction qui cherche un client en fonction de son numero
            => fonction qui creer un mouvement ( quand on creer un mouvement le solde de l'envoyeur et du recepteur change)