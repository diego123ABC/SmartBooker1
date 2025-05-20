<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Nuova Risorsa</h2>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= base_url('admin/risorse/crea') ?>" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <input name="nome" placeholder="Nome risorsa" required><br><br>

  <select name="tipo" required>
    <option value="aula">Aula</option>
    <option value="laboratorio">Laboratorio</option>
    <option value="stampante">Stampante</option>
    <option value="aula_studio">Aula Studio</option>
  </select><br><br>

  <input name="descrizione" placeholder="Descrizione"><br><br>

  <!-- Drag & Drop -->
  <div id="drop-zone" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
    Trascina un'immagine qui oppure clicca per selezionarla
    <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
    <div id="preview" style="margin-top: 10px;"></div>
  </div><br>

  <button type="submit">Crea Risorsa</button>
</form>

<a class="btn" href="<?= base_url('admin/risorse') ?>">Annulla</a>

<script>
  const dropZone = document.getElementById('drop-zone');
  const imageInput = document.getElementById('imageInput');
  const preview = document.getElementById('preview');

  dropZone.addEventListener('click', () => imageInput.click());

  dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.style.background = '#f0f0f0';
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.style.background = '';
  });

  dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.style.background = '';
    const file = e.dataTransfer.files[0];
    if (file) {
      imageInput.files = e.dataTransfer.files;
      preview.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="Anteprima" style="max-width: 100%; max-height: 200px;">`;
    }
  });

  imageInput.addEventListener('change', () => {
    const file = imageInput.files[0];
    if (file) {
      preview.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="Anteprima" style="max-width: 100%; max-height: 200px;">`;
    }
  });
</script>

<?= $this->endSection() ?>
