<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Elenco Prenotazioni</h2>

<ul class="risorse">
<?php foreach ($prenotazioni as $p): ?>
  <li>
    <strong><?= esc($p['utente_nome']) ?></strong> ha prenotato <strong><?= esc($p['risorsa_nome']) ?></strong><br>
    <small>
      Dal: <?= date('d/m/Y H:i', strtotime($p['data_inizio'])) ?> al <?= date('d/m/Y H:i', strtotime($p['data_fine'])) ?><br>
      Stato: <?= ucfirst($p['stato']) ?>
    </small><br>
    <?php if ($p['stato'] === 'attiva'): ?>
      <a href="<?= base_url('admin/prenotazioni/elimina/' . $p['id']) ?>" class="btn" style="color:red;">Elimina</a>
    <?php endif; ?>
    
  </li>
<?php endforeach; ?>
</ul>

<a class="btn" href="<?= base_url('home') ?>">Torna alla home</a>
<a style="float:right;" class="btn" href="<?= base_url('admin/prenotazioni/report') ?>">Report prenotazioni</a>


<?= $this->endSection() ?>