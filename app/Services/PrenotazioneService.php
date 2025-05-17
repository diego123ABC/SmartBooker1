<?php namespace App\Services;

use Config\Database;
use Psr\Log\LoggerInterface;

class PrenotazioneService
{
    protected $db;
    protected $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->db     = Database::connect();
        $this->logger = $logger ?: service('logger');
    }

    /**
     * Aggiorna tutte le prenotazioni scadute da 'attiva' a 'completata'.
     * Ritorna il numero di righe modificate.
     */
    public function aggiornaScadute(): int
    {
        // Inizio transazione
        $this->db->transStart();

        // Update con NOW() di MySQL, senza escapare
        $builder = $this->db->table('prenotazioni');
        $builder->where('stato', 'attiva')
                ->where('data_fine <', 'NOW()', false)
                ->update(['stato' => 'completata']);

        $count = $this->db->affectedRows();

        // Commit transazione
        $this->db->transComplete();

        // Log dell’operazione
        $this->logger->info("Prenotazioni scadute aggiornate: {$count}");

        return $count;
    }
}
