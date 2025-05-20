<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Registrazione</h2>
<form method="post" action="<?= base_url('register') ?>">
  <input name="nome" placeholder="Nome" required>
  <input name="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <select name="ruolo" required>
    <option value="studente">Studente</option>
    <option value="docente">Docente</option>
  </select>
  <button type="submit">Registrati</button>
</form>
<a class="btn" href="<?= base_url() ?>">Hai già un account? Accedi</a>

<?= $this->endSection() ?>