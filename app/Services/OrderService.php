<?php 
namespace App\Services;

class OrderService
{
    //TODOS: Verificar na api do nohat onde é possível informar o banco de imagem para reutiliar o método abaixo
    // adicionar o parametro $bancoImagem
    public function getPreviewStockByUrl($url)
    { 

        return [
            'status'=>true,
            'imagePath'=>'assets/images/3d-car-preview.png'
        ];
    } 

    public function getStockByUrl($url)
    {
        // Enviar os dados para a api em py realizar o download

        //$data = [
        //    'url' => $request->stock_url,
        //];
        
        //$client = new Client();
        //$response = $client->post('<http://endereco-do-seu-servidor-python:5000/receive-data>', [
        //    'json' => $data
        //]);
        
        //$responseBody = json_decode($response->getBody(), true);

        return [
            'status'=>true,
            'imagePath'=>'storage/processed_image/car-3d-ia.jpg'
        ];
    } 
}