@extends('inc.base')

@section('content')

    <h3>Routes</h3>
    <br>

    <ul class="list-group" style="width: 100%; max-width: 500px;">
        @foreach($data['routes'] as $route)
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <span><?= $route['name'] ?>
                    <span class=" ml-1 badge badge-<?= ($route['enabled'] ? 'primary' : 'danger') ?> badge-pill">
                        <?= ($route['enabled'] ? 'enabled' : 'disabled') ?>
                    </span>
                </span>

                <a class="btn btn-primary" href="<?= URLROOT ?>/routes/view/<?= $route['id'] ?>">View</a>
            </li>
        @endforeach
    </ul>

    <br>
    <br>
    <a class="btn btn-primary" href="<?= URLROOT ?>/routes/add">Add Route</a>

@endsection
