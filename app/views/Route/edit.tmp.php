@extends('inc.base')

@section('content')

    <h1>Edit Route</h1>

    <?php if (isset($data['error'])): ?>
        <p>Error: {{ $error }}</p>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/routes/edit/<?= $data['id'] ?>" method="post">
        <input type="text" name="url" id="" value="{{ $url }}" placeholder="Address url">

        <input type="submit" value="Update">
    </form>

@endsection
