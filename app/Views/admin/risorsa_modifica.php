<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Modifica risorsa</h2>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="<?= base_url('admin/risorse/aggiorna/' . $risorsa['id']) ?>" method="post">
  <?= csrf_field() ?>

  <div>
    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" value="<?= esc($risorsa['nome']) ?>" required>
  </div>

  <div>
    <label for="descrizione">Descrizione</label><br>
    <textarea id="descrizione" name="descrizione" rows="4" required><?= esc($risorsa['descrizione']) ?></textarea>
  </div>

  <div>
    <label for="image">Percorso immagine</label>
    <input type="text" id="image" name="image" value="<?= esc($risorsa['image']) ?>">
  </div>

  <button type="submit">Salva modifiche</button>
  <a href="<?= base_url('admin/risorse') ?>">Annulla</a>
</form>

<?= $this->endSection() ?>
