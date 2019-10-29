@extends('inc.base')

@section('content')
  
    <h3 class="display-3 text-center mt-5">Page Not Found</h3>

    <p class="text-center">Sorry, the page at <?= $data['id'] ?> count not be found</p>

    <a href="<?= URLROOT ?>" class="text-center mt-5 h5" style="display: block">Home</a>

@endsection
