<?php

use App\Inscription\Inscription;

require dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require  dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'functions.php';

$pdo = db_connect(1);
$error = null;

if (isset($_POST['name'], $_POST['firstname'], $_POST['mail'], $_POST['password'])) {
    $query = $pdo->prepare('INSERT INTO users (name,firstname,mail,password,created_at)  VALUES(:name,:firstname,:mail,:password,:created)');
    $query->execute([
        'name' => $_POST['name'],
        'firstname' => $_POST['firstname'],
        'mail' => $_POST['mail'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'created' => time()
    ]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1 class="text-center">Inscription</h1>
    <div class="card">
        <div class="card-body">
            <form action="" method="post" class="mb-5">
                <div class="input-group mb-3">
                    <span class="input-group-text"
                        id="basic-addon1">E-mail</span>
                    <input type="email" class="form-control"
                        aria-label="mail" name="mail"
                        aria-describedby="basic-addon1"
                        required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"
                        id="basic-addon1">Nom
                        d'utilisateur</span>
                    <input type="text" class="form-control"
                        aria-label="name" name="name"
                        aria-describedby="basic-addon1"
                        required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"
                        id="basic-addon1">Prénom</span>
                    <input type="text" class="form-control"
                        aria-label="firstname"
                        name="firstname"
                        aria-describedby="basic-addon1"
                        required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"
                        id="basic-addon1">Mot de passe
                    </span>
                    <input type="password"
                        class="form-control"
                        aria-label="password"
                        name="password"
                        aria-describedby="basic-addon1"
                        required>
                </div>
                <button type="submit"
                    class="btn btn-success mx-auto">S'inscrire</button>
            </form>
        </div>
    </div>
    <a href="<?= $router->generate('contact'); ?>">Page
        contact</a>
</body>

</html>