<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Gestione Risorse</h2>

<a class="btn" href="<?= base_url('admin/risorse/nuova') ?>">➕ Aggiungi nuova risorsa</a>

<ul class="risorse">
<?php foreach ($risorse as $r): ?>
  <li>
    <strong><?= esc($r['nome']) ?></strong> (<?= esc($r['tipo']) ?>)<br>
    <small><?= esc($r['descrizione']) ?></small><br>
    <?php if (!empty($r['image'])): ?>
      <img src="<?= base_url($r['image']) ?>" style="width:100px; margin-top:5px; border-radius:4px;"><br>
    <?php endif; ?>
    <a class="btn" href="<?= base_url('admin/risorse/elimina/' . $r['id']) ?>" style="color:red;">Elimina</a>
  </li>
<?php endforeach; ?>
</ul>

<a class="btn" href="<?= base_url('home') ?>">Torna alla home</a>

<?= $this->endSection() ?>