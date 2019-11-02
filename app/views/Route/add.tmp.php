@extends('inc.base')

@section('content')
    <?php if (count($data['errors']) > 0): ?>
        <div class="alert alert-danger" role="alert">
            <h3><strong>Warning:</strong></h3>
            <?php foreach ($data['errors'] as $error): ?>
                <p style="margin: 0"><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/routes/add" method="post">
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="enabled" id="enabled" class="form-check-input" <?= ($data['enabled']) ? 'checked' : '' ?>>
                <label for="enabled" class="form-check-label">Enabled</label>
            </div>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="<?= $data['name'] ?>">
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input class="form-control" type="text" name="url" id="url" value="<?= $data['url'] ?>">
        </div>

        <div class="form-group">
            <input type="submit" value="Add">
        </div>
    </form>

@endsection
