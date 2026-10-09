<?php
$statuses = ['pending' => 'Pending', 'in progress' => 'In progress', 'completed' => 'Completed'];
$selectedStatus = old('status', $task['status'] ?? 'pending');
?>
<?php if ($errors = session()->getFlashdata('errors')): ?>
    <div class="validation-errors" role="alert">
        <p>Please correct the following:</p>
        <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= esc($action, 'attr') ?>">
    <?= csrf_field() ?>
    <div class="field">
        <label for="title">Title <span aria-hidden="true">*</span></label>
        <input id="title" name="title" type="text" maxlength="150" value="<?= esc(old('title', $task['title'] ?? ''), 'attr') ?>" required autofocus>
    </div>
    <div class="field-row">
        <div class="field">
            <label for="task_date">Task date <span aria-hidden="true">*</span></label>
            <input id="task_date" name="task_date" type="date" value="<?= esc(old('task_date', $task['task_date'] ?? ''), 'attr') ?>" required>
        </div>
        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?= esc($value, 'attr') ?>"<?= $selectedStatus === $value ? ' selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-actions">
        <button class="button" type="submit"><?= esc($submitLabel) ?></button>
        <a class="button button-secondary" href="<?= site_url('tasks') ?>">Cancel</a>
    </div>
</form>
