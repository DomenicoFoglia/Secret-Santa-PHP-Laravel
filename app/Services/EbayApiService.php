<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class EbayApiService
{
    protected $baseUrl;
    protected $appId;

    public function __construct()
    {
        //URL di PRODUZIONE
        $this->baseUrl = 'https://svcs.ebay.com/services/search/FindingService/v1';

        $this->appId = env('EBAY_APP_ID');
    }

    protected function mapEbayItems(array $rawData): array
    {
        // Controlla lo stato della risposta
        $ack = data_get($rawData, 'findItemsByKeywordsResponse.0.ack.0', 'Failure');

        if ($ack !== 'Success') {
            return [];
        }

        // Estrai la lista degli articoli 
        $items = data_get($rawData, 'findItemsByKeywordsResponse.0.searchResult.0.item', []);

        if (empty($items)) {
            return [];
        }

        $transformedItems = [];

        // 3. Cicla e mappa i datii
        foreach ($items as $item) {

            $priceValue = data_get($item, 'sellingStatus.0.currentPrice.0.__value__', 'N/A');
            $currencyId = data_get($item, 'sellingStatus.0.currentPrice.0.@currencyId', 'EUR');

            $transformedItems[] = [
                'title' => data_get($item, 'title.0', 'Titolo non disponibile'),

                'price' => "{$priceValue} {$currencyId}",
                'url' => data_get($item, 'viewItemURL.0', '#'),

                'imageUrl' => data_get($item, 'galleryURL.0', data_get($item, 'pictureURLSuperSize.0', null)),
            ];
        }

        return $transformedItems;
    }

    public function searchItems(string $query): array
    {
        if (!$this->appId) {
            return [];
        }

        try {
            $response = Http::get($this->baseUrl, [
                // Parametri richiesti dall'API di eBay (Finding Service)
                'SECURITY-APPNAME' => $this->appId,
                'OPERATION-NAME' => 'findItemsByKeywords',
                'SERVICE-VERSION' => '1.0.0',
                'RESPONSE-DATA-FORMAT' => 'JSON',
                'keywords' => $query,
                'outputSelector' => 'PictureURLSuperSize', // Ottieni immagini di qualità migliore
                'paginationInput.entriesPerPage' => 10, // Limita a 10 risultati per query
                'GLOBAL-ID' => 'EBAY-IT',
            ]);

            if ($response->failed() || $response->serverError() || $response->clientError()) {
                // In caso di errore HTTP, ritorna un array vuoto
                return [];
            }

            // Decodifica JSON e mappa i risultati
            return $this->mapEbayItems($response->json());
        } catch (Throwable $e) {
            // In caso di eccezione, ritorna un array vuoto
            return [];
        }
    }
}
