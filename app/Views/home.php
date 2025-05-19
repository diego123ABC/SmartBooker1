<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Form di ricerca risorse -->
<form action="<?= base_url('risorse/filtra') ?>" method="get">
  <h2>Cerca disponibilità</h2>
  
  <label for="tipo">Tipo di risorsa:</label>
  <select name="tipo" required>
    <option value="">-- Seleziona tipo --</option>
    <option value="aula" <?= set_select('tipo', 'aula') ?>>Aule</option>
    <option value="laboratorio" <?= set_select('tipo', 'laboratorio') ?>>Laboratori</option>
    <option value="stampante" <?= set_select('tipo', 'stampante') ?>>Stampanti</option>
    <?php if (session('user')['ruolo'] === 'studente'): ?>
      <option value="aula_studio" <?= set_select('tipo', 'aula_studio') ?>>Aule Studio</option>
    <?php endif; ?>
  </select>

  <label for="data_inizio">Data inizio:</label>
  <input type="date" name="data_inizio" id="data_inizio" value="<?= set_value('data_inizio') ?>" required>

  <label for="data_fine">Data fine:</label>
  <input type="date" name="data_fine" id="data_fine" value="<?= set_value('data_fine') ?>" required>

  <button type="submit">Filtra</button>
</form>


<h2>Oppure consulta risorse disponibili in questo momento !</h2>

<ul class="risorse">
  <li>
    <strong>Aule</strong><br>
    <a href="<?= base_url('risorse/aula') ?>">Visualizza Aule</a>
  </li>
  <li>
    <strong>Laboratori</strong><br>
    <a href="<?= base_url('risorse/laboratorio') ?>">Visualizza Laboratori</a>
  </li>
  <li>
    <strong>Stampanti</strong><br>
    <a href="<?= base_url('risorse/stampante') ?>">Visualizza Stampanti</a>
  </li>
  <?php if (session('user')['ruolo'] === 'studente'): ?>
    <li>
      <strong>Aule Studio</strong><br>
      <a href="<?= base_url('risorse/aula_studio') ?>">Visualizza Aule Studio</a>
    </li>
  <?php endif; ?>
</ul>

<?= $this->endSection() ?>
