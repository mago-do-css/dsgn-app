<?php 

namespace App\Http\Controllers;

use App\Services\HistoryService; 
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

 
class HistoryController extends Controller{

    protected $orderService;
    protected $historyService;

    public function __construct(HistoryService $historyService){ 
        $this->historyService = $historyService; 
    }
    
    public function getImagesByFilter(Request $request){


        $page = request('page', 1);  
 
        $getHistory = $this->historyService->getDownloadHistory($request);
        $getPaginationData = $this->historyService->getPaginationData($getHistory['lastPage'], $page); 
    
        return view('history', 
            [
                'historyData' => $getHistory['historyData'],
                'page' => $page,
                'paginationData'=> $getPaginationData,
                'selectedOptions'=> $getHistory['selectedOptions']
            ]
        );

    }

}