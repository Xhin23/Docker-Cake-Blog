<?php if ($mode == 'review'): ?>
  <div class="article panel-article">
<?php else: ?>
  <a class="article panel-article" href="/articles/edit/<?= $article->slug ?>">
<?php endif; ?>

  <h3 class="article-title"><?= h($article->title) ?></h3>
  <p class="article-date"><?= $article->created->format(DATE_RFC850) ?></p>
  <p class="article-body panel-article-body"><?= h($article->short_body) ?></p>
  <?php if ($mode == 'review'): ?>
      <a href="/articles/preview/<?= $article->slug ?>" class="preview-article">Preview</a>
      <?= $this->element('approve_article',["article" => $article]) ?>

  <?php endif; ?>

<?php if ($mode == 'review'): ?>
  </div>
<?php else: ?>
  </a>
<?php endif; ?>
