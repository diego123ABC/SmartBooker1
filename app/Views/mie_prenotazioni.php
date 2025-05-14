<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Le mie prenotazioni</h2>

<?php if (empty($prenotazioni)): ?>
  <p>Non hai ancora effettuato prenotazioni.</p>
<?php else: ?>
  <ul class="risorse">
  <?php foreach ($prenotazioni as $p): ?>
    <li>
      <strong><?= esc($p['risorsa_nome']) ?></strong> (<?= esc($p['risorsa_tipo']) ?>)<br>
      <small>Dal: <?= date('d/m/Y H:i', strtotime($p['data_inizio'])) ?>  
      al: <?= date('d/m/Y H:i', strtotime($p['data_fine'])) ?></small><br>
      <em>Stato: <?= ucfirst($p['stato']) ?></em><br>

      <?php if ($p['stato'] === 'attiva'): ?>
        <a href="<?= base_url('prenotazioni/annulla/' . $p['id']) ?>" class="btn" style="color: red;">Annulla</a>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<a class="btn" href="<?= base_url('home') ?>">Torna alla home</a>

<?= $this->endSection() ?>