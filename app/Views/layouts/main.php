<?php
helper('url');
$path  = trim(uri_string(), '/');
$links = [
    ''        => 'Today',
    'tasks'   => 'All Tasks',
    'profile' => 'Profile',
    'about'   => 'About',
];
$loggedIn = session()->has('user_id');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Tasks for Today') ?> | Tasks for Today</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="<?= site_url('/') ?>">Tasks for Today</a>
            <nav aria-label="Main navigation">
                <ul class="nav-list">
                    <?php foreach ($links as $slug => $label): ?>
                        <li>
                            <a href="<?= site_url($slug) ?>"
                               class="nav-link<?= $path === $slug ? ' is-active' : '' ?>"
                               <?= $path === $slug ? 'aria-current="page"' : '' ?>><?= esc($label) ?></a>
                        </li>
                    <?php endforeach; ?>
                    <?php if ($loggedIn): ?>
                        <li><a href="<?= site_url('tasks/new') ?>" class="nav-link<?= $path === 'tasks/new' ? ' is-active' : '' ?>">New Task</a></li>
                        <li>
                            <form class="nav-form" method="post" action="<?= site_url('logout') ?>">
                                <?= csrf_field() ?>
                                <button class="nav-link nav-button" type="submit">Logout</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= site_url('login') ?>" class="nav-link<?= $path === 'login' ? ' is-active' : '' ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main" class="container page">
        <?php if ($message = session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="status"><?= esc($message) ?></div>
        <?php endif; ?>
        <?php if ($message = session()->getFlashdata('error')): ?>
            <div class="alert alert-error" role="alert"><?= esc($message) ?></div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="site-footer">
        <div class="container">Tasks for Today Management System &middot; CodeIgniter 4 &amp; MySQL</div>
    </footer>
</body>
</html>
