<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<header class="page-head">
    <p class="eyebrow">About the system</p>
    <h1>Tasks for Today Management System</h1>
    <p class="lede">A small internal tool that shows what is scheduled today and keeps the full task list in one place.</p>
</header>

<section class="card profile-card">
    <dl class="details">
        <div><dt>Developer</dt><dd><?= esc($developer) ?></dd></div>
        <div><dt>Course</dt><dd><?= esc($course) ?></dd></div>
    </dl>
    <p class="about-note">This system demonstrates CodeIgniter MVC architecture and MySQL database integration: routes call controllers, controllers use models to query the database, and views render the results.</p>
</section>
<?= $this->endSection() ?>
