<?= $this->Html->css('page') ?>
<?= $this->Html->script('page.js',['block' => 'scripts']) ?>

<?= $this->element('header') ?>
<div class="container clearfix" id="content">
    <div id="page">
        <?= $this->fetch('content') ?>
    </div>
</div>
