<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Préfixes</title>
</head>
<body>
    <h1>Préfixes des Opérateurs</h1>

    <form action="/operateur-prefix/save" method="post">
        <select name="idOperateur" required>
            <option value="">-- Choisir un opérateur --</option>
            <?php foreach ($operateurs as $op): ?>
                <option value="<?= $op['id'] ?>"><?= esc($op['libelle']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="text" name="prefix" placeholder="Préfixe (ex: 033)" maxlength="3" required>
        <button type="submit">Ajouter Préfixe</button>
    </form>

    <hr>
    <h2>Liste des Préfixes</h2>
    <ul>
    <?php foreach ($prefixes as $p): ?>
        <li>
            <strong><?= esc($p['prefix']) ?></strong> → <?= esc($p['libelle']) ?>
            <a href="/operateur-prefix/delete/<?= $p['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>