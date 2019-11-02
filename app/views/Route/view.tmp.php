@extends('inc.base')

@section('content')

    <h1><?= $data['name'] ?></h1>

    <hr>
        <p><?= ($data['enabled'] ? 'enabled' : 'disabled') ?></p>
        <p><a href="<?= URLROOT . '/page/' . $data['id'] ?>">
            <?= $data['url'] ?>
        </a></p>
    <hr>

    <ul>
        <li><a href="<?= URLROOT ?>/routes/edit/<?= $data['id'] ?>">Edit Route</a></li>
        <li><a href="<?= URLROOT ?>/routes/delete/<?= $data['id'] ?>">Delete Route</a></li>
    </ul>

@endsection
