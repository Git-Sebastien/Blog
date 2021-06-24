<?php
session_start();
require '../vendor/autoload.php';
require '../functions/functions.php';

$pdo = db_connect(1);
?> <h1 class="main-title">Bienvenue sur la page d'acceuil
</h1>
<a href="<?= $router->generate('contact') ?>">Page de contact</a>