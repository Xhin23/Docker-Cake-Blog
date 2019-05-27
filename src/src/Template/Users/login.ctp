<?php
    $this->extend('/Common/page');
    $this->assign('on_login_page',true)
?>

<h2>Login</h2>
<?= $this->Form->create() ?>
<?= $this->Form->control('email') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>
