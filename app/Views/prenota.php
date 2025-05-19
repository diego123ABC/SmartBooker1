<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Prenota <?= esc($risorsa['nome']) ?></h2>
<div class="regole-uso" style="margin-bottom: 1em; padding: 1em; background: #f8f9fa; border: 1px solid #ddd;">
  <strong>Regole d'uso:</strong>
  <ul>
    <li>Le <b>stampanti</b> possono essere prenotate per <b>1 e una sola ora</b>.</li>
    <li>I <b>laboratori</b>, <b>aule</b> e le <b>aule_studio</b> possono essere prenotati per <b>minimo 2 ore</b> e <b>massimo una giornata</b> (dalle 8:00 alle 18:00).</li>
  </ul>
</div>
<?php if (!empty($dateOccupate)): ?>
  <div class="alert alert-warning" style="margin-bottom: 1em; padding: 1em; background: #fff3cd; border: 1px solid #ffeeba;">
    <strong>Attenzione:</strong> La risorsa è già occupata nelle seguenti date e orari:
    <ul>
      <?php foreach ($dateOccupate as $periodo): ?>
        <li>
          <?= esc(date('d/m/Y H:i', strtotime($periodo['data_inizio']))) ?> - 
          <?= esc(date('d/m/Y H:i', strtotime($periodo['data_fine']))) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<form method="post" action="<?= base_url('prenota') ?>">
  <input type="hidden" name="risorsa_id" value="<?= esc($risorsa['id']) ?>">
  <label>Data Inizio</label>
  <input type="datetime-local" name="data_inizio" required>
  <label>Data Fine</label>
  <input type="datetime-local" name="data_fine" required>
  <button type="submit">Conferma Prenotazione</button>
</form>
<a class="btn" href="<?= base_url('home') ?>">Torna alla home</a>

<?= $this->endSection() ?>