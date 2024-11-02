<?php

namespace App\Http\Controllers;

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

    public function downloadImageByUrl(Request $request)
    {
        try{ 
            $request->validate([
                'stock_url'=> 'required', 
                'isPreview'=> 'required|in:true,false',
            ]);
            
            $getEnum =$this->orderService->requestEnumValidator($request->stock_url); 

            $getFile = $this->orderService->downloadValidator($request, $getEnum);

            //TODO: retornar o resultado do validator
            //url de teste: https://image.shutterstock.com/image-vector/-250nw-2491646071.jpg
          
            return [
                'status' => $getFile['status'],
                'imagePath' => $getFile['imagePath']
            ]; 

        }catch(Exception $e){
            return [
                'status' => false,
                'message'=> 'Erro: ' . $e->getMessage()
            ];
        }  
    }

    public function downloadImagesAtFreepik(Request $request)
    {
        dd($request->freepik_url);

        $data = [
            'url' => $request->freepik_url,
            // seu array de dados aqui
        ];

        $client = new Client();
        $response = $client->post('<http://endereco-do-seu-servidor-python:5000/receive-data>', [
            'json' => $data
        ]);

        $responseBody = json_decode($response->getBody(), true);

        // Processar a resposta conforme necessário
        return $responseBody;
    } 

    public function getImagesByFilter(Request $request){


        $page = request('page', 1);  
 
        $getHistory = $this->orderService->getDownloadHistory($request);
        $getPaginationData = $this->orderService->getPaginationData($getHistory['lastPage'], $page); 
    
        return view('history', 
            [
                'historyData' => $getHistory['historyData'],
                'page' => $page,
                'paginationData'=> $getPaginationData,
                'selectedOptions'=> $getHistory['selectedOptions']
            ]
        );

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