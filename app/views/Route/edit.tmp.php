@extends('inc.base')

@section('content')

    <form action="<?= URLROOT ?>/routes/edit/<?= $data['id'] ?>" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" 
                value="<?= $data['name'] ?>"
                class="form-control <?= (array_key_exists('name', $data['errors'])) ? 'is-invalid' : '' ?>" 
            >
            <?php if (array_key_exists('name', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['name'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" name="url" id="url" 
                value="<?= $data['url'] ?>"
                class="form-control <?= (array_key_exists('url', $data['errors'])) ? 'is-invalid' : '' ?>" 
            >
            <?php if (array_key_exists('url', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['url'] ?></div>
            <?php endif; ?>
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
