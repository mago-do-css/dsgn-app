<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Enums\BancoImagemEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\DownloadHistory; 
use Carbon\Carbon;
use App\Models\UserLimits;  
//use GuzzleHttp\Client;
//use Illuminate\Validation\Rule;

class OrderService
{
    /**
     * Verifica se as informações da requisição estão válidas; 
     */
    public function requestEnumValidator($stock_url)
    {
        try {
            $enum = match (true) {
                Str::contains($stock_url, 'istockphoto.com') => BancoImagemEnum::istock,
                Str::contains($stock_url, 'shutterstock.com') => BancoImagemEnum::shutterstock,
                Str::contains($stock_url, 'freepik.com') => BancoImagemEnum::freepik,
                Str::contains($stock_url, 'elements.envato.com') => BancoImagemEnum::envato,
                Str::contains($stock_url, 'motionarray.com') => BancoImagemEnum::motionarray,
                Str::contains($stock_url, 'graphicpear.com') => BancoImagemEnum::graphipear,
                default => false,
            }; 

            if (!$enum)
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
            if ($request->isPreview){
                $getFile = $this->getPreviewStockByUrl($request->stock_url, $enum->getStockParam());
            }else{
                $this->getDownloadLimit();
                $getFile = $this->getStockByUrl($request->stock_url, $enum->getDescription());
            }

            return $getFile;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }  

    public function saveHistory($stock_url, $imagePreview, $enum, $isSave, $orderCode){
        try { 

            if(!$isSave && $orderCode == null){ 
              $getCode =  DownloadHistory::create([
                    'user_id' => Auth::user()->id,  
                    'stock_image_preview' => $imagePreview,
                    'order_code'=> Str::uuid(), 
                    'date' => Carbon::now(),
                ]); 

                return $getCode['order_code'];
            }else{
                $stockName = null;
            
                $pattern = $enum->getStockRegex();
                preg_match($pattern, $stock_url, $matches);
                
                if ($matches)
                    $stockName = str_replace('-', ' ', $matches[1]);   
                
                DownloadHistory::where('order_code', $orderCode)
                ->where('user_id', Auth::user()->id)
                ->update([  
                        'stock_name' => $stockName,
                        'stock_origin' => $enum, 
                        'stock_origin_param' => $enum->getStockParam(),
                        'stock_type' => $enum->getStockType(),
                        'stock_url' => $stock_url, 
                        'date' => Carbon::now(),
                ]); 
            }   
            
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    } 
    
    public function decreaseDownloadLimit($downloadLimitData){
        try{ 
            $downloadLimitData->limit = $downloadLimitData->limit - 1;
            $downloadLimitData->date_time_today = date('Y-m-d H:i:s');
            $downloadLimitData->save();
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        } 
    }
    
    #region PRIVATE Download 
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
                'imagePath' => $response->json()['data']['image'],
                'save'=> false
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

            return [
                'status' => true,
                'imagePath' => 'car-3d-ia.jpg',
                'save' => true,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    } 

    private function getDownloadLimit(){
        try{
            $userId = Auth::user()->getAuthIdentifier();
            
            $getDownloadLimit = UserLimits::where('user_id', $userId)->first();

            if ($getDownloadLimit == null) {
                throw new Exception("Falha ao obter limte de downloads! Contacte o suporte!");
            }

            if ($getDownloadLimit->limit == 0) {
                throw new Exception("Limite de downloads excedido!");
            } 
          
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        } 
    }
    #endregion 
} 