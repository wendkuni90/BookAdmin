Dans ce dossier(site), il y'aura deux types de page principal:
1- La page destinée à l'administrateur principal
2- La page destinée aux différents bibliothécaires

Concernant l'Administrateur Principal(fonctionnalités):
    Dashboard: il verra le nombre total de livres,
        le nombre total d'etudiants et le nombre des bibliothécaires
        Il aura une liste des emprunts recents
    Utilisateurs: il verra un tableau de bibliothécaires et d'etudiants, il pourra 
        editer et supprimer
    Bibliothèques: Il aura une liste des Bibliothèques, il pourra les éditer et les supprimer
    Emprunts: Cette fois-ci il aura la liste de tous les emprunts
    addBibliothèque: Il pourra ajouter une nouvelle Bibliothèque
    addBibliothecaire: Il pourra manager(ajouter) les comptes des bibliothécaires
        Notons que plusieurs bibliothécaires peuvent etre rattachés à la même Bibliothèque
    Setting: Il pourra editer(changer nom, mot de passe) son propre compte
    Logout: il pourra se déconnecter. 

    Concernant la sécurité, si la session de l'administrateur n'est pas lancé, 
    aucune de ses pages devrait être accessible

Concernant les bibliothécaires(fonctionnalités):
    Dashboard:il verra le nombre total de livres,
        le nombre total d'etudiants et le nombre total d'emprunts.
        Il aura une liste des emprunts recents
    Utilisateurs: il verra un tableau d'etudiants, il pourra 
        editer et supprimer
    Livres: Il aura sa liste de livres, il pourra les éditer et les supprimer
    addBook: Il pourra ajouter un livre
    addStudent: Il pourra ajouter un etudiant
    Emprunts: Il aura la liste de tout ses emprunts de livre(il peut editer 
        un emprunt pour changer son statut:'Retouné') et il pourra aussi 
        gérer un nouvel emprunts.
    logout: se déconnecter.

    Notons qu'un etudiant ne peut avoir plus de 3 emprunts en cours.
    Un etudiant ne peut être supprimé si il a un emprunt en cours.

    Concernant la sécurité des comptes, idem que pour l'administrateur principal
