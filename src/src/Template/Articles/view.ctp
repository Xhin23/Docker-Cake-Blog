<?php $this->extend('/Common/page'); ?>

<?= $this->element('article') ?>

<?php if ($auth->user('role') == 'editor' && isset($is_preview)): ?>
    <?= $this->element('approve_article',["article" => $article]) ?>
<?php endif; ?>
