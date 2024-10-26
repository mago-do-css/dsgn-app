<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Enums\BancoImagemEnum;

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
                'isPreview'=> 'required',
            ]);
            
            $this->orderService->requestValidator($request); 

            $getFile = $this->orderService->downloadValidator($request);
          
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
}
