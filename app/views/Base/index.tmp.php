@extends('inc.home')

@section('content')

    <div class="jumbotron jumbotron-fluid" style="background-color: hsl(208, 16%, 50%)">
        <div class="container">
            <h1 class="display-3 text-white">Kort</h1>
            <p class="lead text-white">Make Links Great Again</p>
        </div>
    </div>

    <br>
    <br>

    <div class="container">
        <p>Need to share a link, but it's too long? Don't worry, Kort is here to help. Just add a new link, and Kort will give you back a friendly link.</p>
        <br>
        <p>With Kort, you can also how often and when a link was visited.</p>
    </div>

    <br>
    <br>
    <br>

    <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container">
            
            <p class="text-white">Are you interested? <a href="<?= URLROOT ?>/register">Register</a></p>

            <p class="text-white">Already have an account? <a href="<?= URLROOT ?>/login">Login</a></p>

        </div>
    </div>


@endsection
