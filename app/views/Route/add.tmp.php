@extends('inc.base')

@section('content')

    <h1>Add Route</h1>

    @if($data['error'] !== '')
        <p>Error: {{ $error }}</p>
    @endif

    <form action="<?= URLROOT ?>/routes/add" method="post">
        <input type="text" name="url" id="" value="{{ $url }}" placeholder="Address url">

        <input type="submit" value="Submit">
    </form>

@endsection
