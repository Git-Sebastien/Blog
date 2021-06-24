<?php

$router->map('GET', '/', 'home', 'home');
$router->map('GET | POST', '/contact', 'contact', 'contact');
$router->map('GET', '/blog/articles/[*:article_name]-[*:content]', 'blog/article', 'article');
$router->map('GET | POST', '/authentification', 'auth', 'auth');
$router->map('GET', '/logout', 'logout', 'logout');
$router->map('GET | POST', '/inscription', 'registration/inscription', 'inscription');