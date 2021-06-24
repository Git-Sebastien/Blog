<?php
session_start();

use App\Articles\{
    AddComment,
    Comment,
};
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require  dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'functions.php';

$pdo = db_connect(1);
$error_message = null;
$error_pdo = null;
$error = null;
$success = null;
$session_status = null;

try {
    if (isset($_POST['content'], $_POST['title'], $_POST['username'])) {
        //Instancie et créer un commentaire avec les données du formulaire
        $comment = new Comment($_POST['content'], $_POST['title'], $_POST['username']);
        //Vérifie que le commentraire est valide
        if ($comment->isValid()) {
            new AddComment($comment, $pdo);
            $_POST = [];
            $success = "Formulaire envoyé";
        } else {
            $error_message = $comment->errors_comment();
        }
    } elseif (isset($_POST['content'], $_POST['title'], $_SESSION['user']['firstname'])) {
        $comment = new Comment($_POST['content'], $_POST['title'], $_SESSION['user']['firstname']);
        if ($comment->isValid()) {
            new AddComment($comment, $pdo);
            $_POST = [];
            $success = "Commentaire envoyé";
        } else {
            $error_message = $comment->errors_comment();
        }
    }
    //Suppression des articles
    if (isset($_GET['article_id'])) {
        $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
        $query->execute([
            'id' => $_GET['article_id']
        ]);
    }
} catch (PDOException $e) {
    $error_pdo = "Erreur renvoyé par le serveur " . $e->getMessage();
}

//Selectionne tous les articles de la BDD
$query = $pdo->query('SELECT * FROM articles');
$articles = $query->fetchAll(PDO::FETCH_CLASS, 'App\Articles\GetComment');


if (!empty($_SESSION['user'])) {
    $session_status = 'Bonjour ' . $_SESSION['user']['firstname'];
}
?> 
<?php if ($error) : ?> 
    <div class="alert alert-danger">
        <p class="text-center"><?= $error ?></p>
    </div> 
    
<?php elseif ($success) : ?> 
    <div class="alert alert-success">
        <p class="text-center"><?= $success ?></p>
    </div> 
<?php endif ?> 

<main style="padding: 50px;">
    <div class="container">
        <a href="<?= $router->generate('inscription') ?>" class="btn btn-success streched-link float-end">Creer un compte</a> 
        <?php if ($session_status) : ?>
            <div class="alert alert-warning">
                <div class="row justify-content-end">
                    <div class="col-4">
                        <span class="text-muted"><?= $session_status ?></span>
                    </div>
                    <div class="col-4">
                        <a href="<?= $router->generate('logout') ?>" class=" btn btn-secondary streched-link">Se deconnecter</a>
                    </div>
                </div>
            </div> 
        <?php else : ?> 
            <a href="<?= $router->generate('auth') ?>" class="btn btn-success streched-link">Se connecter</a> 
        <?php endif ?> 
        <h1 class="text-center">
            <?php $title ?? "Ajouter un commentaire" ?></h1>
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <?php if (empty($_SESSION['user'])) : ?>
                        <h4>Nom d'utilisateur : </h4>
                            <input type="text" name="username" id="" class="form-control" value="">
                        <?php if (isset($error_message['username'])) : ?>
                            <div class="invalid" style="color: red;font-size:12px">
                                <?= $error_message['username']; ?>
                            </div> 
                        <?php endif ?>
                    </div>
                    <div class="form-group mt-3">
                        <h4>Titre : </h4>
                        <input type="text" name="title" id="" class="form-control" value="<?= htmlentities($_POST['title'] ?? "") ?>">
                        <?php if (isset($error_message['title'])) : ?>
                            <div class="invalid" style="color: red;font-size:12px">
                                <?= $error_message['title']; ?>
                            </div> 
                        <?php endif ?>
                    </div>
                    <h4>Contenu : </h4>
                    <div class="form-group mt-3">
                        <textarea rows="4" name="content" id="" class="form-control"></textarea>
                        <?php if (isset($error_message['content'])) : ?>
                        <div class="invalid" style="color: red;font-size:12px">
                            <?= $error_message['content']; ?>
                        </div> <?php endif ?>
                    </div> 
                    <?php else : ?> 
                        <div class="form-group mt-3">
                            <h4>Titre : </h4>
                            <input type="text" name="title" id="" class="form-control" value="<?= htmlentities($_POST['title'] ?? "") ?>">
                            <?php if (isset($error_message['title'])) : ?>
                            <div class="invalid" style="color: red;font-size:12px">
                                <?= $error_message['title']; ?>
                            </div> <?php endif ?>
                        </div>
                        <h4>Contenu : </h4>
                        <div class="form-group mt-3">
                            <textarea rows="4" name="content" id="" class="form-control"></textarea>
                            <?php if (isset($error_message['content'])) : ?>
                                <div class="invalid" style="color: red;font-size:12px">
                                    <?= $error_message['content']; ?>
                                </div> 
                            <?php endif ?>
                        </div> 
                    <?php endif ?> 
                    <button type="submit" class="btn btn-success mt-3">Publier</button>
                </form>
            </div>
        </div>
        <h2 class="text-center mt-4">Vos commentaires : </h2> 
        <?php foreach ($articles as $article) : ?>
            <div class="card mt-4">
                <div class="card-body">
                    <p class="small text-muted">Ecrit le
                        <?= htmlentities($article->created_at->format('d/m/Y à H:i')) ?>
                        par
                        <?= htmlentities($article->username) ?>
                    </p>
                    <h2 class="text-center">
                        <?= htmlentities($article->title) ?>
                    </h2>
                    <p class="text-center">
                        <?= $article->getExcerpt() ?></p>
                    <a href="<?= $router->generate('article', ['article_name' => str_replace('+', '-', urlencode(htmlentities($article->title))), 'content' => $article->content]); ?>" class="btn btn-success streched-link m-auto">Voir l'article
                    </a>
                    <a href="<?= $router->generate('contact') ?>?article_id=<?= $article->id ?>"class="btn btn-success streched-link float-end">Supprimer
                        le commentaire</a>
                </div>
            </div> 
        <?php endforeach ?>
    </div>
