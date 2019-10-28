@extends('inc.base')

@section('content')

    <h1>Route <span style="color: hsl(100, 50%, 50%)">{{ $id }}</span></h1>

    <hr>
        <p>{{ $url }}</p>
    <hr>

    <ul>
        <li><a href="<?= URLROOT ?>/routes/edit/<?= $data['id'] ?>">Edit Route</a></li>
        <li><a href="<?= URLROOT ?>/routes/delete/<?= $data['id'] ?>">Delete Route</a></li>
    </ul>

@endsection
