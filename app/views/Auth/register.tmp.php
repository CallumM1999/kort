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

    <form action="<?= URLROOT ?>/register" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" value="<?= $data['email'] ?>">
        </div>

        <div class="form-group">
            <label for="confirm_email">Confirm Email</label>
            <input type="text" name="confirm_email" id="confirm_email" class="form-control" value="<?= $data['confirm_email'] ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="<?= $data['password'] ?>">
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="<?= $data['confirm_password'] ?>">
        </div>

        <div class="form-group">
            <input type="submit" value="Register">
        </div>

        <br>

        <div class="form-group">
            <a href="<?= URLROOT ?>/login">Login</a>
        </div>
    </form>

@endsection
