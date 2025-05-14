<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Prenota una Risorsa</h2>
<form method="post" action="<?= base_url('prenota') ?>">
  <input type="hidden" name="risorsa_id" value="<?= esc($risorsa_id) ?>">
  <label>Data Inizio</label>
  <input type="datetime-local" name="data_inizio" required>
  <label>Data Fine</label>
  <input type="datetime-local" name="data_fine" required>
  <button type="submit">Conferma Prenotazione</button>
</form>
<a class="btn" href="<?= base_url('home') ?>">Torna alla home</a>

<?= $this->endSection() ?>