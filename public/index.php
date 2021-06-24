<?php 
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$router = new AltoRouter();


require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.php';
$match = $router->match();

if (is_array($match)) {
    require '../elements/header.php';

    if (is_callable($match['target'])) {
        call_user_func_array($match['target'],$match['params']);
    }
    else{
        $params = $match['params'];
        require "../templates/{$match['target']}.php";
    }
    require "../elements/footer.php";
}
else{
    echo "Error 404. Page not found";
}