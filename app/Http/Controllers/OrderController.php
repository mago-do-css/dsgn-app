<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http; 
use Illuminate\Validation\Rule;
use App\Enums\BancoImagemEnum;
use App\Models\DownloadHistorical;

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
            
            $this->orderService->requestValidator($request); 

            $getFile = $this->orderService->downloadValidator($request);

            //TODO: após sucesso no download, salvar as informações no histórico
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

        //TODO: CRIAR UM MÉTODO NO SERVIÇO PARA BATER NO BANCO DE DADOS OU CAMADA NO REPOSITÓRIO
        // $request->validate([
        //     'filter'=> 'required|in:free,stock',
        // ]);

        $getHistorical = DownloadHistorical::query();

        //TODO: criar uma documentação para explicar como usar isso
        //obtendo o id do usuário através do middleware que está autenticado
        $getHistorical->where('user_id', $request->user()->id);

        if(!empty($request->imageOrigin)){ 
            foreach ($request->image_origin as $image_bank) { 
                if (!is_null($image_bank)) {
                    $getHistorical->orWhere('image_bank', $image_bank); 
                }
            } 
        }

        if (!empty($request->min_date) && !empty($request->max_date)) { 
            $getHistorical->whereBetween('date', [$request->min_date, $request->max_date]);
        }

        // Paginação - ajusta o número de itens por página conforme necessário
        $perPage = 12; // Por exemplo, 12 itens por página
        $getHistorical = $getHistorical->paginate($perPage); 

        
        //TODO: PARTE 2, BATER NA API DO NOHAT COM o parametro image_url e os respectivos bancos de imagens (validando pelo enum ) PARA RETORNAR O PREVIEW DAS IMAGENS
        //TODO: verificar se a url do preview tem algum vencimento, caso não haja, slvar o seu valor fixo
        

        return view('historical', 
            [
                'historicalData' => $getHistorical,
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