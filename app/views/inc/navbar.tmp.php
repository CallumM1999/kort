<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow mb-3">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= URLROOT ?>"><?= SITENAME ?></a>

  <div class="container d-flex flex-column flex-md-row justify-content-end">


    <?php if (isset($_SESSION['id'])): ?>

      <a class="py-2 d-none d-md-inline-block text-white" href="<?= URLROOT ?>/logout">Logout</a>

    <?php else: ?>

      <a class="py-2 d-none d-md-inline-block text-white" href="<?= URLROOT ?>/login">Login</a>

    <?php endif; ?>

  </div>
</nav>