@extends('inc.base')

@section('content')

    <h1>Route <span style="color: hsl(100, 50%, 50%)">{{ $id }}</span></h1>

    <hr>
        <p>{{ $url }}</p>
    <hr>

    <ul>
        <li>Edit Route</li>
        <li>Delete Route</li>
    </ul>

@endsection
