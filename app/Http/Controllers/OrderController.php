<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function downloadImagesAtShutter(Request $request)
    {
        dd($request->shutter_url);

        $data = [
            'url' => $request->shutter_url,
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
