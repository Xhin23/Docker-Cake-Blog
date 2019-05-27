<!-- File: src/Template/Articles/index.ctp -->

<?php $title = $this->fetch('title','All Articles'); ?>

<div class="articles">
    <?php if ($title): ?>
        <h2><?=$title?></h2>
    <?php endif; ?>

    <?php $this->extend('/Common/page'); ?>

    <?= $this->element('nothing_found',['list' => $articles,'name' => 'articles']) ?>

    <?php foreach ($articles as $article): ?>
        <div class="article-wrapper">
            <?= $this->element('article',["article" => $article,"is_index" => true]) ?>
        </div>
    <?php endforeach; ?>
</div>
