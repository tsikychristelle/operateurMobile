<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="/client-numero/login" method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" required>
        <label for="numero">Numéro:</label>
        <input type="text" name="numero" id="numero" required>
        <button type="submit">Login</button>
    </form>
    
</body>
</html>