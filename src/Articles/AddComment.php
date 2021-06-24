<?php 

namespace App\Articles;


class AddComment extends Comment{
    
    
    public function __construct(Comment $comment,$pdo)
    {
        $comment = $pdo->prepare('INSERT INTO articles (content, title, username, created_at) VALUES (:content,:title,:username, :created)');
            $comment->execute([
            'content' =>$_POST['content'],
            'title' =>$_POST['title'],
            'username' => $_POST['username'] ?? $_SESSION['user']['firstname'],
            'created' => time()
        ]); 
    }
}