@extends('inc.base')

@section('content')

    <h1>Dashboard</h1>

    <hr>

    <h3>Links</h3>
    <ul>
        @foreach($data['routes'] as $route)

            <li><a href="<?= URLROOT ?>/routes/view/<?= $route['id'] ?>">Route: <?= $route['url'] ?></a></li>

        @endforeach
    </ul>

    <a href="<?= URLROOT ?>/routes/add">Add Route</a>

@endsection
