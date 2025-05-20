<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Modifica risorsa</h2>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="<?= base_url('risorse/aggiorna/' . $risorsa['id']) ?>" method="post">
  <?= csrf_field() ?>

  <div class="form-group" style="margin-bottom: 1em;">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="<?= esc($risorsa['nome']) ?>" required>
  </div>

  <div class="form-group" style="margin-bottom: 1em;">
    <label for="descrizione">Descrizione</label><br>
    <textarea class="form-control" id="descrizione" name="descrizione" rows="4" required><?= esc($risorsa['descrizione']) ?></textarea>
  </div>

  <div class="form-group" style="margin-bottom: 1em;">
    <label for="image">Percorso immagine</label>
    <input type="text" class="form-control" id="image" name="image" value="<?= esc($risorsa['image']) ?>">
  </div>

  <button type="submit" class="btn btn-primary">Salva modifiche</button>
  <a href="<?= base_url('admin/risorse') ?>" class="btn btn-secondary">Annulla</a>
</form>

<?= $this->endSection() ?>
