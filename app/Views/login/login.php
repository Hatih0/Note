<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2>SysInfo</h2>
    <p>Systeme d'information</p>

    <h1>Connexion</h1>
    <p>Connecter-vous à votre espace de travail</p>

    <form action="/login" method="post">
        <label for="email">Addresse e-mail</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Se souvenir de moi</label>

        <button type="submit">Se connecter</button>
        <p>Pas encore de compte ? <a href="#"> Contacter votre administrateur </a></p>

    </form>
</body>
</html>