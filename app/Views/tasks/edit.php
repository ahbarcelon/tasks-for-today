<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <p class="eyebrow">Task management</p>
    <h1>Edit Task</h1>
    <p class="lede">Update this task's details.</p>
</header>

<section class="card form-card">
    <?= $this->include('tasks/_form') ?>
</section>
<?= $this->endSection() ?>
