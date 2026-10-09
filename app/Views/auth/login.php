<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <p class="eyebrow">Task management</p>
    <h1>Login</h1>
    <p class="lede">Log in with the demo account to create, edit, and archive tasks.</p>
</header>

<section class="card form-card">
    <?php if ($errors = session()->getFlashdata('errors')): ?>
        <div class="validation-errors" role="alert">
            <p>Please correct the following:</p>
            <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" value="<?= esc(old('username', 'demo.student'), 'attr') ?>" autocomplete="username" required autofocus>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
        </div>
        <button class="button" type="submit">Login</button>
    </form>
</section>
<?= $this->endSection() ?>
