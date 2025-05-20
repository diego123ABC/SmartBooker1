<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'SmartBooker' ?></title>
  <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>

<header>
 <!-- <img src="<?= base_url('images/logo.png') ?>" alt="Logo" style="height: 100px; margin-right: 1rem;"> -->
  <h1>SmartBooker</h1>
  <?php if (session()->has('user')): ?>
    <nav>
      <a href="<?= base_url('home') ?>">Home</a>
      <?php if (session('user')['ruolo'] === 'admin'): ?>
        <a href="<?= base_url('admin/risorse') ?>">Gestione Risorse</a>
        <a href="<?= base_url('admin/prenotazioni') ?>">Gestione Prenotazioni</a>
      <?php else: ?>
        <a href="<?= base_url('prenotazioni') ?>">Le mie prenotazioni</a>
      <?php endif; ?>

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