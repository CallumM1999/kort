@extends('inc.base')

@section('content')

    <?php if(array_key_exists('main', $data['errors'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $data['errors']['main'] ?>
        </div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/register" method="post">

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
            <label for="confirm_email">Confirm Email</label>
            <input type="text" name="confirm_email" id="confirm_email" 
                class="form-control <?= (array_key_exists('confirm_email', $data['errors'])) ? 'is-invalid' : '' ?>" 
                value="<?= $data['confirm_email'] ?>"
            >
            <?php if (array_key_exists('confirm_email', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['confirm_email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" 
                class="form-control <?= (array_key_exists('password', $data['errors'])) ? 'is-invalid' : '' ?>" 
                value="<?= $data['password'] ?>"
            >
            <?php if (array_key_exists('password', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['password'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" 
                class="form-control <?= (array_key_exists('confirm_password', $data['errors'])) ? 'is-invalid' : '' ?>" 
                value="<?= $data['confirm_password'] ?>"    
            >
            <?php if (array_key_exists('confirm_password', $data['errors'])): ?>
                <div class="invalid-feedback"><?= $data['errors']['confirm_password'] ?></div>
            <?php endif; ?>
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
