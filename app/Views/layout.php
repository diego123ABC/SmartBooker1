<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'SmartBooker' ?></title>
  <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>

<header>
  <h1>SmartBooker</h1>
  <?php if (session()->has('user')): ?>
    <nav>
      <a href="<?= base_url('home') ?>">Home</a>
      <a href="<?= base_url('prenotazioni') ?>">Le mie prenotazioni</a>
      <a href="<?= base_url('logout') ?>">Logout</a>
    </nav>
  <?php endif; ?>
</header>

<main class="container">
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <?= $this->renderSection('content') ?>
</main>

<footer>
  <p>&copy; <?= date('Y') ?> SmartBooker - Tutti i diritti riservati</p>
</footer>

</body>
</html>