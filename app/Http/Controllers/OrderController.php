<?php

namespace App\Http\Controllers;

use App\Services\HistoryService;
use App\Services\OrderService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 


class OrderController extends Controller
{
    protected $orderService; 

    public function __construct(OrderService $orderService){
        $this->orderService = $orderService; 
    }
 
/**
 * Valida os dados da requisição e processa o download ou pré-visualização
 * de uma imagem a partir da URL de estoque especificada.
 *
 * @param Request $request O objeto de requisição HTTP contendo os campos 'stock_url' e 'isPreview'.
 * 
 * @return array Um array contendo o status da operação e o caminho da imagem ou uma mensagem de erro. 
 */ 
    public function downloadImageByUrl(Request $request)
    {
        try{ 
            $request->validate([
                'stock_url'=> 'required', 
                'isPreview'=> 'required',
            ]);
            //TODO: ajustar o in do validate   'isPreview'=> 'required|in:0,1',
            
            $getEnum = $this->orderService->requestEnumValidator($request->stock_url); 

            $getFile = $this->orderService->downloadValidator($request, $getEnum);
  
            $result = $this->orderService->saveHistory($request->stock_url, $getFile['imagePath'], $getEnum, $getFile['save'], $request->orderCode );

            if($getFile['status'] && $getFile['save'])
                $this->orderService->decreaseDownloadLimit($getFile); 
          
            return [
                'status' => $getFile['status'],
                'imagePath' => $getFile['imagePath'],
                'orderCode' => $result != null ? $result : null
            ]; 

        }catch(Exception $e){
            return [
                'status' => false,
                'message'=> 'Erro: ' . $e->getMessage()
            ];
        }  
    }

    public function teste(){
        // adicionar o parametro $bancoImagem
        //TODO: para testar
        $url = "https://www.shutterstock.com/pt/image-photo/smiling-30s-latin-hispanic-middleaged-business-2491646071";

        $encodedUrl = urlencode($url); 
        
        $endpoint = "https://vip.neh.tw/api/stockinfo/shutterstock/null?url={$encodedUrl}"; 

        $response = Http::withHeaders([
            'X-Api-Key' => 'sV6mS2Q3NArE2s351IXovmEOcXaSwk',
        ])->get($endpoint); 
 
    
        dd($response->json());
    } 
}