@extends('inc.base')

@section('content')

    <div class="jumbotron mt-5 mb-5">
        <h1 class="display-3 text-center">{{ $title }}</h1>
        <p class="lead text-center">{{ $copy }}</p>
    </div>

    <div class="link-group">
        <a class="link-group-button" href="https://github.com/CallumM1999/Eleganta">Source</a>
        <a class="link-group-button" href="https://github.com/CallumM1999/Eleganta/blob/master/DOCUMENTATION.md">Documentation</a>
    </div>

@endsection
