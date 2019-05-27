<?= $this->Html->css('panel') ?>
<?= $this->Html->script('panel.js',['block' => 'scripts']) ?>

<?= $this->element('header') ?>
<div class="container clearfix" id="content">
    <div id="page">
        <?= $this->fetch('content') ?>
    </div>
</div>
