<?php if (!isset($mode)) { $mode = 'edit'; } ?>

<h2><?=$title?></h2>

<?= $this->element('nothing_found', ['list' => $articles,'name' => 'articles']) ?>

<div class="panel-article-wrapper">
<?php foreach ($articles as $article):  ?>
  <?= $this->element('panel_article',["article" => $article,"mode" => $mode]) ?>
<?php endforeach; ?>
</div>
