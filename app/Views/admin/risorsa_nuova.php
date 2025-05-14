<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Nuova Risorsa</h2>

<form method="post" action="<?= base_url('admin/risorse/crea') ?>">
  <input name="nome" placeholder="Nome risorsa" required>
  <select name="tipo" required>
    <option value="aula">Aula</option>
    <option value="laboratorio">Laboratorio</option>
    <option value="stampante">Stampante</option>
    <option value="aula_studio">Aula Studio</option>
  </select>
  <input name="descrizione" placeholder="Descrizione">
  <input name="image" placeholder="Percorso immagine (es. images/nome.jpg)">
  <button type="submit">Crea Risorsa</button>
</form>

<a class="btn" href="<?= base_url('admin/risorse') ?>">Annulla</a>

<?= $this->endSection() ?>