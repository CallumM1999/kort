<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-1 shadow">
  <div class="container">
    <a class="navbar-brand m-0" href="<?= URLROOT ?>">
      <h2 class="m-0"><?= SITENAME ?></h2>
    </a>

    <div class="d-flex flex-column flex-md-row justify-content-end">


      <?php if (isset($_SESSION['id'])): ?>

        <a class="py-2 d-md-inline-block text-white" href="<?= URLROOT ?>/logout">Logout</a>

      <?php else: ?>

        <a class="py-2 d-md-inline-block text-white" href="<?= URLROOT ?>/login">Login</a>

      <?php endif; ?>

    </div>
  </div>
</nav>