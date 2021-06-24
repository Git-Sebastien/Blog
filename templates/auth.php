<?php
session_start();
require '../vendor/autoload.php';
require '../functions/functions.php';
$pdo = db_connect(1);
$success = null;
$error = null;

$query = $pdo->prepare('SELECT * FROM users');
$query->execute();
$users = $query->fetchAll();

if (isset($_POST['username'], $_POST['pwd'])) {
    foreach ($users as $user) {
        if ($_POST['username'] === $user->firstname && password_verify($_POST['pwd'], $user->password)) {
            $_SESSION['user'] = [
                'firstname' => $_POST['username']
            ];
            header("Location:{$router->generate('contact')}");
        } else {
            $error = "Identifiants incorrect";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .form-control:focus {
        border-color: rgb(245, 66, 66);
        box-shadow: 0 0 0 0.2rem rgba(245, 66, 66, 0.50);
    }
    </style>
</head>

<body> 
    <?php if ($success) : ?> 
        <div class="alert alert-success"> <?= $success ?> </div>
    <?php endif ?> 
    <?php if ($error) : ?> 
        <div class="alert alert-danger"> 
            <?= $error ?> 
        </div>
    <?php endif ?> 
    <div class="card p-3 w-50 mx-auto">
        <form action="" method="post" class="">
                <div class="form-group col-3 mx-auto">
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" name="username" class="form-control mt-2">
                </div>
                <div class="form-group col-3 mx-auto">
                    <label for="pwd">Mot de passe : </label>
                    <input type="password" name="pwd" id="" class="form-control mt-2">
                    <button type="submit" class="btn btn-success mt-2">Se connecter</button>
                </div>
        </form>
    </div>
    <a href="<?= $router->generate('contact'); ?>">Page contact</a>
</body>

</html>