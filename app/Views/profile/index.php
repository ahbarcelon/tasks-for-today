<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <p class="eyebrow">Account</p>
    <h1>Profile</h1>
    <p class="lede">The demo user stored in the database.</p>
</header>

<?php if (empty($user)): ?>
    <section class="card empty-state">
        <h2>No user found</h2>
        <p>The users table is empty. Run <code>php spark db:seed TasksTodaySeeder</code> to add the demo user.</p>
    </section>
<?php else: ?>
    <section class="card profile-card" aria-labelledby="profile-name">
        <h2 id="profile-name"><?= esc($user['full_name']) ?></h2>
        <dl class="details">
            <div><dt>Username</dt><dd><?= esc($user['username']) ?></dd></div>
            <div><dt>Full name</dt><dd><?= esc($user['full_name']) ?></dd></div>
            <div><dt>Email</dt><dd><a href="mailto:<?= esc($user['email'], 'attr') ?>"><?= esc($user['email']) ?></a></dd></div>
            <div><dt>Created</dt><dd><time datetime="<?= esc($user['created_at'], 'attr') ?>"><?= date('F j, Y g:i A', strtotime($user['created_at'])) ?></time></dd></div>
        </dl>
    </section>
<?php endif; ?>
<?= $this->endSection() ?>
