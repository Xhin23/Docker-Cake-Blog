<?php
$this->extend('/Common/panel');

echo $this->Html->link(
    ' + New Article',
    ['action' => 'add'],
    ['class' => 'new-blog-post']
);

echo $this->element('panel_article_wrapper',[
    "articles" => $articles,
    "title" => 'Saved Drafts'
]);
