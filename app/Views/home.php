<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Scegli una sezione</h2>

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