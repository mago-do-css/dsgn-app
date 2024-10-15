<?php 
namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Enums\BancoImagemEnum;

class OrderService
{
    /**
    * Verifica se as informações da requisição estão válidas; 
    */
    public function requestValidator(Request $request){
        try{ 
            $enum = BancoImagemEnum::tryFrom($request->code_IB);  

            if (!$enum)
                throw new Exception("Código inválido fornecido.");
            
            $validatedName = $enum->getDescription(); 
    
            // if(!Str::contains($request->stock_url, $validatedName))
            //     throw new Exception($message =  "Somente pode ser enviado URLs do ". $validatedName ."!");
    
            if(!$enum->getVideoCondition() && Str::contains($request->stock_url, $enum->getVideoDescription()))
                throw new Exception($message =  "Vídeos do ". $validatedName ." somente sob demanda. Entre em contato com o suporte!");

        }catch(Exception $e){
            throw new Exception('Erro: ' . $e->getMessage());
        }     
    }

    /**
    * Direcionar o tipo do download para preview ou donwload na api PY; 
    */
    public function downloadValidator(Request $request){
        try{
            $enum = BancoImagemEnum::tryFrom($request->code_IB);  
            $validatedName = $enum->getDescription(); 

            if($request->isPreview)
            $getFile = $this->getPreviewStockByUrl($request->stock_url, $enum->getStockParam());
            else
            $getFile =  $this->getStockByUrl($request->stock_url, $validatedName );  

            return $getFile;

        }catch(Exception $e){
            throw new Exception('Erro: ' . $e->getMessage());
        } 
    }   
    
    private function getPreviewStockByUrl($url, $stock_param)    
    { 
        try{
            // adicionar o parametro $bancoImagem
            //TODO: para testar
            //$url = "https://www.shutterstock.com/pt/image-photo/smiling-30s-latin-hispanic-middleaged-business-2491646071";

            $encodedUrl = urlencode($url);
        
            $endpoint = "https://vip.neh.tw/api/stockinfo/{$stock_param}/null?url={$encodedUrl}"; 

            $response = Http::withHeaders([
                'X-Api-Key' => 'sV6mS2Q3NArE2s351IXovmEOcXaSwk',
            ])->get($endpoint); 
         
            if(isset($response->json()['error']) && $response->json()['error'])
                throw new Exception($message = "Erro na requisição das imagens!");

            return [
                'status' => true,
                'imagePath' => $response->json()['data']['image']
            ];
            
        }catch(Exception $e){
            throw new Exception('Erro: ' . $e->getMessage());
        } 
    }  

    private function getStockByUrl($url, $enpointStockName)
    { 
        try{
            //Enviar os dados para a api em py realizar o download
                
            $urlEncode = urlencode($url);

            $endpoint = "https://endpoint.com.br/download_stock/". $enpointStockName ."/data={$urlEncode}"; 
            
            $response = Http::withHeaders([
                'X-Api-Key' => 'sV6mS2Q3NArE2s351IXovmEOcXaSwk',
            ])->get($endpoint);  

            return [
                'status'=> true,
                'imagePath'=> 'car-3d-ia.jpg',
                'id'=> null,
            ];

        }catch(Exception $e){
            throw new Exception('Erro: ' . $e->getMessage());
        }  
    }    
}