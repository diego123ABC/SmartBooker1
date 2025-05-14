<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><?= esc($tipo) ?></h2>

<ul class="risorse">
<?php foreach ($risorse as $risorsa): ?>
  <li>
    <strong><?= esc($risorsa['nome']) ?></strong><br>
    <?php if (!empty($risorsa['image'])): ?>
      <img src="<?= base_url($risorsa['image']) ?>" alt="<?= esc($risorsa['nome']) ?>" style="width:100%; max-width:300px; border-radius:6px; margin-top:8px;">
    <?php endif; ?>
    <p><?= esc($risorsa['descrizione']) ?></p>
    <a href="<?= base_url('prenota/' . $risorsa['id']) ?>">Prenota</a>
  </li>
<?php endforeach; ?>
</ul>

<a class="btn" href="<?= base_url('home') ?>">Torna alla home</a>

<?= $this->endSection() ?>