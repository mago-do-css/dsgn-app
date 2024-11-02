<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Enums\BancoImagemEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLimits;
use App\Models\DownloadHistory;
use Carbon\Carbon;

class OrderService
{
    /**
     * Verifica se as informações da requisição estão válidas; 
     */
    public function requestEnumValidator($stock_url)
    {
        try {
            $code_bancoImage = match (true) {
                Str::contains($stock_url, 'istockphoto.com') => 0,
                Str::contains($stock_url, 'shutterstock.com') => 1,
                Str::contains($stock_url, 'freepik.com') => 2,
                Str::contains($stock_url, 'elements.envato.com') => 3,
                Str::contains($stock_url, 'motionarray.com') => 4,
                Str::contains($stock_url, 'graphicpear.com') => 5,
                default => false,
            };

            $enum = BancoImagemEnum::tryFrom($code_bancoImage);

            if (!$enum && !$code_bancoImage)
                throw new Exception("Url não autenticada. Verifique novamente ou contate o suporte!");

            $validatedName = $enum->getDescription();

            if (!$enum->getVideoCondition() && (Str::contains($stock_url, $enum->getVideoDescription()) || Str::contains($stock_url, "/v%C3%ADdeo/")))
                throw new Exception($message =  "Vídeos do " . $validatedName . "somente sob demanda. Entre em contato com o suporte!");

            return $enum;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Direcionar o tipo do download para preview ou donwload na api PY; 
     */
    public function downloadValidator(Request $request, $enum)
    {
        try {
            if ($request->isPreview)
                $getFile = $this->getPreviewStockByUrl($request->stock_url, $enum->getStockParam());
            else
                $getFile =  $this->getStockByUrl($request->stock_url, $enum->getDescription());

            return $getFile;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function getPreviewStockByUrl($url, $stock_param)
    {
        try {
            // adicionar o parametro $bancoImagem
            //TODO: para testar
            //$url = "https://www.shutterstock.com/pt/image-photo/smiling-30s-latin-hispanic-middleaged-business-2491646071";

            $encodedUrl = urlencode($url);

            $endpoint = "https://vip.neh.tw/api/stockinfo/{$stock_param}/null?url={$encodedUrl}";
        
            $response = Http::withHeaders([
                'X-Api-Key' => 'sV6mS2Q3NArE2s351IXovmEOcXaSwk',
            ])->get($endpoint);

            if (isset($response->json()['error']) && $response->json()['error'])
                throw new Exception($message = "Erro na requisição das imagens!");

            return [
                'status' => true,
                'imagePath' => $response->json()['data']['image']
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function getStockByUrl($url, $enpointStockName)
    {
        try {
            //Enviar os dados para a api em py realizar o download

            // $urlEncode = urlencode($url);

            // $endpoint = "https://endpoint.com.br/download_stock/". $enpointStockName ."/data={$urlEncode}"; 

            // $response = Http::withHeaders([
            //     'X-Api-Key' => 'sV6mS2Q3NArE2s351IXovmEOcXaSwk',
            // ])->get($endpoint);   

            //$userId = Auth::user()->id;

            
            //TODO: pegar resposta de erro da api em py e setar como true para indicar que é uma image premiun
            $urlValidate = "https://www.shutterstock.com/pt/image-photo/vibrant-autumn-colours-on-tree-foliage-2504823041";
            $stockPremiumBlocked = false;

            if($stockPremiumBlocked){
                $response = Http::withHeaders([
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive',
                    'Upgrade-Insecure-Requests' => '1',
                    'Cache-Control' => 'max-age=0',
                ])->get($urlValidate);

                $body = $response->getBody();

                if (strpos($body, 'mui-1pzresd-overlayIcon') !== false) {
                    throw new Exception("Este conteúdo é <b>premium, compra somente sob demanda</b>. Caso queira adquirir entre em contato com o suporte. Atenciosamente, equipe Designer Elite."); 
                }  
            }

            $userId = Auth::user()->getAuthIdentifier();
            
            $getDownloadLimit = UserLimits::where('user_id', $userId)->first();

            if ($getDownloadLimit == null) {
                throw new Exception("Falha ao obter limte de downloads! Contacte o suporte!");
            }

            if ($getDownloadLimit->limit == 0) {
                throw new Exception("Limite de downloads excedido!");
            }

            $getDownloadLimit->limit = $getDownloadLimit->limit - 1;
            $getDownloadLimit->date_time_today = date('Y-m-d H:i:s');
            $getDownloadLimit->save();

            return [
                'status' => true,
                'imagePath' => 'car-3d-ia.jpg',
                'id' => null,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getDownloadHistory($request)
    {
        try {

            $getHistory = DownloadHistory::query();

            //TODO: criar uma documentação para explicar como usar isso
            //obtendo o id do usuário através do middleware que está autenticado
            $getHistory->where('user_id', $request->user()->id);

            if (!empty($request->images_origin)) {
                $getHistory->whereIn('image_origin', array_map(function ($image_bank) {
                    return BancoImagemEnum::from($image_bank)->name;
                }, $request->images_origin));
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');

                $getHistory->whereBetween('date', [$startDate, $endDate]);
            }

            // Paginação - ajusta o número de itens por página conforme necessário. Por exemplo, 12 itens por página
            $perPage = 12;
            $getHistory = $getHistory->paginate($perPage);

            $lastPage = $getHistory->lastPage();

            return [
                'historyData' => $getHistory,
                'lastPage' => $lastPage,
                'selectedOptions' => $request->images_origin,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getPaginationData($lastPage, $page)
    {
        $maxPagePerView = 5;

        // Calcule os números de início e fim da paginação de forma flexível
        $halfRange = floor($maxPagePerView / 2);
        $startNumber = max(1, $page - $halfRange); //ex: 4-2 = 2 então o start será 2
        $endNumber = min($lastPage, $page + $halfRange); //ex: 4+2 = 6 então o end será 6

        //explicação: verifica se o current page é menor que o last page, caso for igual, ele pulará o If
        if ($endNumber - $startNumber + 1 < $maxPagePerView) {
            if ($startNumber === 1) {
                $endNumber = min($lastPage, $maxPagePerView);
            } elseif ($endNumber === $lastPage) {
                $startNumber = max(1, $endNumber - $maxPagePerView + 1);
            }
        }

        return [
            'startNumber' => $startNumber,
            'endNumber' => $endNumber,
            'previousPage' => max(1, $page - 1),
            'nextPage' =>min($lastPage, $page + 1),
        ];
    }
}
