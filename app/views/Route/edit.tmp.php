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

    <form action="<?= URLROOT ?>/routes/edit/<?= $data['id'] ?>" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="<?= $data['name'] ?>">
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input class="form-control" type="text" name="url" id="url" value="<?= $data['url'] ?>">
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitches" <?= ($data['enabled']) ? 'checked' : '' ?>>
                <label class="custom-control-label" for="customSwitches">Enable Route</label>
            </div>
        </div>

        <br>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Update">
        </div>
    </form>

@endsection
