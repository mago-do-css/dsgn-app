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
                //'code_IB'=>  [Rule::enum(BancoImagemEnum::class)],
                'isPreview'=>'required',
            ]);

            //TODO: separar as validações numa camada de serviço
            //modificar o getPreviewStockByUrl para uma private function
            //code_IB: código do image bank
            $enum = BancoImagemEnum::tryFrom($request->code_IB);  

            $validatedName = $enum->getDescription(); 

            if(!Str::contains($request->stock_url, $validatedName))
                throw new Exception($message =  "Somente pode ser enviado URLs do ". $validatedName ."!");

            if($enum->getVideoCondition() && Str::contains($request->stock_url, $enum->getVideoDescription()))
                throw new Exception($message =  "Somente pode ser enviado imagens do ". $validatedName ."!");
 
            if($request->isPreview){ 
                $getFile = $this->orderService->getPreviewStockByUrl($request->stock_url, $enum->getStockParam());
            }else{
               $getFile =  $this->orderService->getStockByUrl($request->stock_url); 
            }

            if(!$getFile['status'])
                throw new Exception($message =  $getFile['message']);

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

    public function downloadImagesAtiStock(Request $request)
    {
        // $getPreview = $this->orderService->getPreviewStockByUrl("testeUrl");
    //   dd( $getPreview );

        //$data = [
        //    'url' => $request->istock_url,
        //    // seu array de dados aqui
        //];
//
        //$client = new Client();
        //$response = $client->post('<http://endereco-do-seu-servidor-python:5000/receive-data>', [
        //    'json' => $data
        //]);
//
        //$responseBody = json_decode($response->getBody(), true);
//
        // Processar a resposta conforme necessário
        //return $responseBody;
    }
}
