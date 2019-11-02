@include('inc.header')

  <?php if(isset($data['title'])): ?>

    <div class="mt-5">
      <h1><?= $data['title'] ?></h1>
      <hr>
      <br>
    </div>

  <?php endif; ?>

  @yield('content')

@include('inc.footer')
