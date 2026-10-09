<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <p class="eyebrow">Task management</p>
    <h1>New Task</h1>
    <p class="lede">Add a task to the schedule.</p>
</header>

<section class="card form-card">
    <?= $this->include('tasks/_form') ?>
</section>
<?= $this->endSection() ?>
