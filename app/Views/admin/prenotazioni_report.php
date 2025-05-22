<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Report Prenotazioni per Risorsa</h2>

<canvas id="graficoPrenotazioni" width="400" height="200"></canvas>

<a class="btn" href="<?= base_url('admin/prenotazioni') ?>">Torna alle prenotazioni</a>
<!--libreria chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('graficoPrenotazioni').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($report, 'risorsa')) ?>,
      datasets: [{
        label: 'Numero di prenotazioni',
        data: <?= json_encode(array_column($report, 'totale')) ?>,
        backgroundColor: 'rgba(52, 152, 219, 0.6)',
        borderColor: 'rgba(41, 128, 185, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?= $this->endSection() ?>
