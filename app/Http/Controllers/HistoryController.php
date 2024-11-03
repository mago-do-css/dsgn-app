<?php 

namespace App\Http\Controllers;

use App\Services\HistoryService; 
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

 
class HistoryController extends Controller{
 
    protected $historyService;

    public function __construct(HistoryService $historyService){  
        $this->historyService = $historyService; 
    }
    
    public function getImagesByFilter(Request $request){
        $page = request('page', 1);  
 
        if(!empty($request->search))
            $getSearchTranslation = $this->historyService->translateStockName($request->search);
        else
            $getSearchTranslation = '';

        $getHistory = $this->historyService->getDownloadHistory($request, $getSearchTranslation);
        $getPaginationData = $this->historyService->getPaginationData($getHistory['lastPage'], $page); 
    
        return view('history', 
            [
                'historyData' => $getHistory['historyData'],
                'page' => $page,
                'paginationData'=> $getPaginationData,
                'selectedOptionsImageBank'=> $getHistory['selectedOptionsImageBank'],
                'selectedOptionsStockType' => $getHistory['selectedOptionsStockType'],
                'selectedOptionOrdernation'=>$getHistory['selectedOptionOrdernation']
            ]
        );
    }

    public function traduzirTextoTeste(Request $request){
        $texto = 'imagem de teste';
        return $this->historyService->translateStockName($texto);
    }
}