<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <div class="page-head-row">
        <div>
            <p class="eyebrow">Full schedule</p>
            <h1>All Tasks</h1>
        </div>
        <?php if (session()->has('user_id')): ?>
            <a class="button" href="<?= site_url('tasks/new') ?>">New Task</a>
        <?php endif; ?>
    </div>
    <p class="lede">Every task in the database, ordered by date.</p>
</header>

<?php if (empty($tasks)): ?>
    <section class="card empty-state">
        <h2>No tasks yet</h2>
        <p>There are no active tasks.<?= session()->has('user_id') ? ' Create one to get started.' : ' Log in to create one.' ?></p>
        <?php if (session()->has('user_id')): ?><a class="button" href="<?= site_url('tasks/new') ?>">Create a task</a><?php endif; ?>
    </section>
<?php else: ?>
    <?= $this->include('partials/summary') ?>
    <?php $caption = 'All tasks ordered by date'; ?>
    <?= $this->include('partials/task_table') ?>
<?php endif; ?>
<?= $this->endSection() ?>
