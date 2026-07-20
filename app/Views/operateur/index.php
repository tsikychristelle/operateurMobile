<!DOCTYPE html>
<html>
<head>
    <title>Liste des Opérateurs</title>
</head>
<body>
    <h1>Opérateurs</h1>

    <form action="/operateur/save" method="post">
        <input type="text" name="libelle" placeholder="Nom de l'opérateur (ex: Orange)" required>
        <button type="submit">Ajouter Opérateur</button>
    </form>

    <hr>
    <h2>Liste des Opérateurs</h2>
    <ul>
    <?php foreach ($operateurs as $op): ?>
        <li>
            <?= esc($op['libelle']) ?> 
            <a href="/operateur/delete/<?= $op['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>