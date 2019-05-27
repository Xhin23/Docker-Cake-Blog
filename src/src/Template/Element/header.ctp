<?php
$roles = Array(
    'author' => ['Author CP','Articles','manage'],
    'editor' => ['Editor CP','Articles','review'],
    'admin' => ['Admin CP','Users','index']
);

$my_role = '';
if ($auth->user('id'))
{
    $my_role = $roles[$auth->user('role')];
}
?>
<nav class="top-bar expanded" data-topbar role="navigation">
    <ul class="title-area large-3 medium-4 columns">
        <li class="name">
            <h1><a href=""><?= $this->Html->link(
                $this->fetch('header_title','Home'),
                '/'
            ) ?></a></h1>
        </li>
    </ul>
    <div class="top-bar-section">
        <ul class="right">
          <?php if (!$auth->user('id') && !$this->fetch('on_login_page')): ?>
            <li><?= $this->Html->link('Login',['controller' => 'Users', 'action' => 'login']) ?></li>
          <?php elseif ($my_role): ?>
            <li><?= $this->Html->link($my_role[0],['controller' => $my_role[1], 'action' => $my_role[2]]) ?></li>
            <li><?= $this->Html->link('Logout',['controller' => 'Users', 'action' => 'logout']) ?></li>
          <?php endif; ?>
        </ul>
    </div>
</nav>
