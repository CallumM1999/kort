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


    <form action="<?= URLROOT ?>/login" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" value="<?= $data['email'] ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="<?= $data['password'] ?>">
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="stay_logged" id="stay_logged" class="form-check-input" <?= ($data['stay_logged']) ? 'checked' : '' ?>>
                <label for="stay_logged" class="form-check-label">Stay logged in</label>
            </div>
        </div>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Login">
        </div>

        <br>

        <div class="form-group">
            <a href="<?= URLROOT ?>/register">Register</a>
        </div>
    </form>

@endsection
