<?php
/** @var array $tasks */
$todayKey = date('Y-m-d');
$canManage = session()->has('user_id');
?>
<div class="card table-card">
    <table class="task-table">
        <caption class="visually-hidden"><?= esc($caption ?? 'Task list') ?></caption>
        <thead>
            <tr>
                <th scope="col">Task</th>
                <th scope="col">Status</th>
                <th scope="col">Task date</th>
                <th scope="col">Created</th>
                <?php if ($canManage): ?><th scope="col">Actions</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <?php $slug = str_replace(' ', '-', $task['status']); ?>
            <tr>
                <th scope="row" class="task-title"><?= esc($task['title']) ?></th>
                <td data-label="Status"><span class="badge badge-<?= esc($slug, 'attr') ?>"><?= esc(ucfirst($task['status'])) ?></span></td>
                <td data-label="Task date">
                    <span><time datetime="<?= esc($task['task_date'], 'attr') ?>"><?= date('M j, Y', strtotime($task['task_date'])) ?></time>
                    <?php if ($task['task_date'] === $todayKey): ?><span class="today-tag">Today</span><?php endif; ?></span>
                </td>
                <td data-label="Created"><time datetime="<?= esc($task['created_at'], 'attr') ?>"><?= date('M j, Y g:i A', strtotime($task['created_at'])) ?></time></td>
                <?php if ($canManage): ?>
                    <td data-label="Actions" class="task-actions">
                        <a class="button button-secondary button-small" href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>">Edit</a>
                        <form method="post" action="<?= site_url('tasks/' . $task['id'] . '/delete') ?>">
                            <?= csrf_field() ?>
                            <button class="button button-danger button-small" type="submit">Archive</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
