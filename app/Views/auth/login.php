<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Login</h2>
<form method="post" action="<?= base_url('login') ?>">
  <input name="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <button type="submit">Accedi</button>
</form>
<a class="btn" href="<?= base_url('register') ?>">Non hai un account? Registrati</a>

<?= $this->endSection() ?>