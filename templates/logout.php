<?php
session_start();
$timer = 5;
unset($_SESSION['user']);

header('refresh:' . $timer . ';url=' . $router->generate('home') . '');

?> <p class="center">Vous allez être redirigé vers la page d'acceuil dans 5 secondes, si ce n'est pas le cas, 
<a href="<?= $router->generate('home') ?>">cliquez ici</a></p>