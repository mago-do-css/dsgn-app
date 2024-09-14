<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function downloadImagesAtShutter(Request $request)
    {
        try{
            
            $request->validate([
                'stock_url'=> 'required'
            ]);

            if(!Str::contains($request->stock_url, 'shutterstock')){
                return [
                    'status'=>false,
                    'message'=>'Somente pode ser enviado URLs do ShutterStock!'
                ];
            }

            if(Str::contains($request->stock_url, '/video/')){
                return [
                    'status'=> false,
                    'message'=> 'Somente pode ser enviado imagens do ShutterStock!'
                ];
            }

            if($request->isPreview){
                //chamar o serviço de busca do preview na api do nohat
                $responseBody = [
                    'status' => true,
                    'imagePath' => '3d-car-preview.png'
                ];
            }else{
                //$data = [
                //    'url' => $request->stock_url,
                //];
                
                //$client = new Client();
                //$response = $client->post('<http://endereco-do-seu-servidor-python:5000/receive-data>', [
                //    'json' => $data
                //]);
                
                //$responseBody = json_decode($response->getBody(), true);
                
                $responseBody = [
                    'status' => true,
                    'imagePath' => 'car-3d-ia.jpg'
                ];
            }

            

            return $responseBody;


        }catch(Exception $e){
            return [
                'status' => false,
                'message'=> 'Campo da URL não pode ser vazio.'
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
        dd($request->istock_url);

        $data = [
            'url' => $request->istock_url,
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
