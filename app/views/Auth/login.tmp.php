@extends('inc.base')

@section('content')
  
    <?php if(array_key_exists('main', $data['errors'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $data['errors']['main'] ?>
        </div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/login" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" 
                class="form-control <?= (array_key_exists('email', $data['errors'])) ? 'is-invalid' : '' ?>" 
                value="<?= $data['email'] ?>"
            >
            <?php if (array_key_exists('email', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"
                value="<?= $data['password'] ?>"
                class="form-control <?= (array_key_exists('password', $data['errors'])) ? 'is-invalid' : '' ?>"     
            >
            <?php if (array_key_exists('password', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['password'] ?></div>
            <?php endif; ?>
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
