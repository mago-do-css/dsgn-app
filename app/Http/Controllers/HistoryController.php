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
        try{
            $page = request('page', 1);  
 
            //coalescing  nul
            $getSearchTranslation = $request->search ?: null; 
                
            if($getSearchTranslation != null)
            $getSearchTranslation = $this->historyService->translateStockName($request->search);
    
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
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        } 
    }

    public function traduzirTextoTeste(Request $request){
        $texto = 'imagem de teste';
        return $this->historyService->translateStockName($texto);
    }

    public function showUserLimit()
    {
        return $this->historyService->getLimitInfo();
    }
}