<div class="card">
    <div class="card-body">
        <h2 class="text-center">
            <?= $params['article_name'] ?></h2>
        <p class="text-center"><?= $params['content'] ?></p>
    </div>
</div>
<a href="<?= $router->generate('contact') ?>">Revenir au
    articles</a>