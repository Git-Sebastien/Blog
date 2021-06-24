<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR .'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require  dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'functions.php';

$pdo = db_connect(1);
$success = false;
$error = null;

try{
if (isset($_POST['content'],$_POST['title'],$_POST['username'])) {
    $query = $pdo->prepare('INSERT INTO articles (content, title, username, created_at) VALUES (:content,:title,:username, :created)');
    $query->execute([
        'content' => $_POST['content'],
        'title' => $_POST['title'],
        'username' => $_POST['username'],
        'created' => time() 
    ]);
    $_POST = [];
    $success = true;
}


var_dump($message->isValid());

if (isset($_GET['article_id'])) {
    $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $query->execute([
        'id' => $_GET['article_id']
    ]);
}
}catch(PDOException $e){
    $error = "Erreur renvoyé par le serveur " .$e->getMessage(); 
}

$query = $pdo->query('SELECT * FROM articles');
$articles = $query->fetchAll(PDO::FETCH_CLASS,'App\Message');

require  dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'header.php';

?>


<?php if($error): ?>
    <?= $error?>
<?php endif ?>

<main>

<div class="container">
            <h1 class="text-center">Ajouter un commentaire</h1>
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                <h4>Nom d'utilisateur : </h4>
                    <input type="text" name="username" id="" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <h4>Titre : </h4>
                    <input type="text" name="title" id="" class="form-control">
                </div>
                <h4>Contenu : </h4>
                <div class="form-group mt-3">
                   <textarea rows="4" name="content" id="" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-3">Envoyer</button>
            </form>
        </div>    
    </div>  

    <h2 class="text-center">Vos commentaires : </h2>
    <?php foreach($articles  as $article): ?>
        <div class="card mt-4">
            <div class="card-body">
            <p class="small text-muted">Ecrit le <?= $article->created_at->format('d/m/Y à H:i')?> par <?=$article->username?></p>
                <h2 class="text-center"><?= htmlentities($article->title) ?></h2>
                <p class="text-center"><?=$article->getBody()?></p>
                <a href="/index.php?article_id=<?=$article->id?>" class="btn btn-success streched-link float-end">Supprimer le commentaire</a>
             </div>
        </div>    
    <?php endforeach ?>

</div>

<?php 
require  dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'footer.php';
 
