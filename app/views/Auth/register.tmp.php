@extends('inc.base')

@section('content')
  
    <div class="container">
        <h1>Register</h1>

        <form action="<?= URLROOT ?>/register" method="post">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" value="Register">
            </div>

            <div class="form-group">
                <a href="<?= URLROOT ?>/login">Login</a>
            </div>
        </form>
    </div>

@endsection
