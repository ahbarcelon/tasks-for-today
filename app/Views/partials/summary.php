<?php /** @var array $counts */ ?>
<section class="summary" aria-label="Task summary">
    <div class="stat stat-pending"><span class="stat-value"><?= (int) $counts['pending'] ?></span><span class="stat-label">Pending</span></div>
    <div class="stat stat-in-progress"><span class="stat-value"><?= (int) $counts['in progress'] ?></span><span class="stat-label">In progress</span></div>
    <div class="stat stat-completed"><span class="stat-value"><?= (int) $counts['completed'] ?></span><span class="stat-label">Completed</span></div>
</section>
