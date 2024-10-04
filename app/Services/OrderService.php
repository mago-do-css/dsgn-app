<?php 
namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderService
{
    //TODO: Verificar na api do nohat onde é possível informar o banco de imagem para reutiliar o método abaixo
    // adicionar o parametro $bancoImagem
    public function getPreviewStockByUrl($url, $stock_param)    
    { 
        try{
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
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        } 
    } 

    public function getStockByUrl($url)
    {
        // Enviar os dados para a api em py realizar o download

       //$data = [
       //   'url' => $url,
       //];
       //  
       //  //opção 1
       // //$client = new Client();
       // //$response = $client->post('<http://endereco-do-seu-servidor-python:5000/receive-data>', [
       // //    'json' => $data
       // //]);
       // //
       // //$responseBody = json_decode($response->getBody(), true);
        //https://vip.neh.tw/api/stockinfo/{site}/{id}?url={URL encode}
        //https://vip.neh.tw/api/me
            // //opção 2  
            //    $response = Http::withHeaders([
                //    'X-Api-Key' => 'sV6mS2Q3NArE2s351IXovmEOcXaSwk',
            //    ])->get("https://vip.neh.tw/api/me");

            //    dd($response->json());  
            
        return [
            'status'=>true,
            'imagePath'=>'car-3d-ia.jpg',
            'id'=> null,
        ];
    } 
}