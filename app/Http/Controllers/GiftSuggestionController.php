<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Services\EbayApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GiftSuggestionController extends Controller
{
    protected EbayApiService $ebayApiService;

    /**
     * Inietta il servizio API di eBay.
     */
    public function __construct(EbayApiService $ebayApiService)
    {
        $this->ebayApiService = $ebayApiService;
    }

    /**
     * Mostra i suggerimenti regalo da eBay per un partecipante specifico, 
     * eseguendo una ricerca separata per ogni regalo preferito.
     */
    public function show(Participant $participant)
    {
        // Ottieni la collezione dei regali preferiti
        $favoriteGifts = $participant->favoriteGifts;
        $ebayItems = new Collection(); // Inizializziamo la Collection vuota per i risultati totali
        $searchQueries = []; // Array per tracciare le query effettivamente eseguite

        if ($favoriteGifts->isNotEmpty()) {

            // Cicla su ogni regalo preferito
            foreach ($favoriteGifts as $gift) {
                $query = $gift->name; // La query è il nome del singolo regalo
                $searchQueries[] = $query; // Aggiungi alla lista delle query eseguite

                try {
                    // Esegui la chiamata API per la singola query. 
                    $rawResults = $this->ebayApiService->searchItems($query);

                    // Converti il risultato in una Collection e uniscilo alla collezione totale
                    $ebayItems = $ebayItems->merge(collect($rawResults));
                } catch (\Exception $e) {
                    // In caso di errore, si ignora e si passa al regalo successivo.
                    // Ritorna un array vuoto nel Service e prosegue.
                    continue;
                }
            }
        }

        // Rimuovi duplicati (se lo stesso oggetto appare in più ricerche) e passa i dati alla vista
        return view('participants.suggestions-show', [
            'participant' => $participant,
            'favoriteGifts' => $favoriteGifts,
            'ebayItems' => $ebayItems->unique('url'),
            'searchQueries' => $searchQueries
        ]);
    }
}
