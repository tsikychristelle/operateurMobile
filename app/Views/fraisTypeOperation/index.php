<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Configurations frais type operation</h1>
    <form action="/frais-type-operation/save" method="post">
        <label for="typeOperation">Type:</label>
        <select name="typeOperation" id="typeOperation" required>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>"><?= $type['type'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="debut">Début:</label>
        <input type="number" name="debut" id="debut" required>
        <label for="fin">Fin:</label>
        <input type="number" name="fin" id="fin" required>
        <label for="frais">Frais:</label>
        <input type="number" name="frais" id="frais" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>