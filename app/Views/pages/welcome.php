<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <p class="eyebrow">Daily overview</p>
    <h1>Tasks for Today</h1>
    <p class="lede"><time datetime="<?= date('Y-m-d') ?>"><?= esc($today) ?></time></p>
</header>

<?php if (empty($tasks)): ?>
    <section class="card empty-state">
        <h2>Nothing scheduled for today</h2>
        <p>No tasks have today's date. Browse everything planned so far, or run the seeder to load sample data.</p>
        <a class="button" href="<?= site_url('tasks') ?>">View all tasks</a>
    </section>
<?php else: ?>
    <?= $this->include('partials/summary') ?>
    <?php $caption = 'Tasks scheduled for today'; ?>
    <?= $this->include('partials/task_table') ?>
<?php endif; ?>
<?= $this->endSection() ?>
