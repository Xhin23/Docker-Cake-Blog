<?php
$this->extend('/Common/panel');

echo $this->element('panel_article_wrapper',[
    "articles" => $articles,
    "title" => "Articles to Review",
    "mode" => 'review'
]);
