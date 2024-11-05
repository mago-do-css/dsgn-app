<?php

namespace App\Services;

use App\HistoryTrait;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Enums\BancoImagemEnum;
use App\Enums\StockTypeEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLimits;
use App\Models\DownloadHistory;
use Carbon\Carbon;

class HistoryService
{
    use HistoryTrait;
    public function getDownloadHistory($request, $search)
    {
        try {

            $getHistory = DownloadHistory::query();

            //TODO: criar uma documentação para explicar como usar isso 
            //obtendo o id do usuário através do middleware que está autenticado
            $getHistory->where('user_id', $request->user()->id);

            if (!empty($request->stocks_origin)) {

                $getHistory->whereIn('stock_origin', array_map(function ($stock) {
                    //return BancoImagemEnum::from($stock);
                    return BancoImagemEnum::fromName($stock);
                }, $request->stocks_origin));
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');

                $getHistory->whereBetween('date', [$startDate, $endDate]);
            }

            if (!empty($request->search)) {
                $getHistory->where('stock_name', 'like', '%' . $request->search . '%');
            }

            if (!empty($request->stocks_type)) {

                $getHistory->whereIn('stock_type', array_map(function ($type) {
                    // return StockTypeEnum::from($type)->value;
                    return StockTypeEnum::fromName($type);
                }, $request->stocks_type));
            }

            if (!empty($request->ordernation)) {
                $getHistory->when(request()->input('ordernation'), function ($query, $ordernation) {
                    switch ($ordernation) {
                        case 'order':
                            $query->orderBy('stock_name', 'asc');
                            break;
                        case 'date_max':
                            $query->orderBy('date', 'desc');
                            break;
                        case 'date_min':
                            $query->orderBy('date', 'asc');
                            break;
                    }
                });
            } else {
                $getHistory->orderBy('date', 'desc');
            };

            // Paginação - ajusta o número de itens por página conforme necessário. Por exemplo, 12 itens por página
            $perPage = 12;
            //$getHistory = $getHistory->paginate($perPage); 
            $getHistory = $getHistory->select()->paginate($perPage);

            //TODO: MELHORAR A PERFORMANCE
            // Converte o valor de stock_type para a string do enum
            $getHistory->getCollection()->transform(function ($item) {
                $item->stock_origin = BancoImagemEnum::from($item->stock_origin)->name;
                $item->stock_type = StockTypeEnum::from($item->stock_type)->getStockTypeDescription();
                return $item;
            });

            $lastPage = $getHistory->lastPage();

            return [
                'historyData' => $getHistory,
                'lastPage' => $lastPage,
                'selectedOptionsImageBank' => $request->stocks_origin,
                'selectedOptionsStockType' => $request->stocks_type,
                'selectedOptionOrdernation' => $request->ordernation,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getPaginationData($lastPage, $page)
    {
        $maxPagePerView = 5;

        // Calcule os números de início e fim da paginação de forma flexível
        $halfRange = floor($maxPagePerView / 2);
        $startNumber = max(1, $page - $halfRange); //ex: 4-2 = 2 então o start será 2
        $endNumber = min($lastPage, $page + $halfRange); //ex: 4+2 = 6 então o end será 6

        //explicação: verifica se o current page é menor que o last page, caso for igual, ele pulará o If
        if ($endNumber - $startNumber + 1 < $maxPagePerView) {
            if ($startNumber === 1) {
                $endNumber = min($lastPage, $maxPagePerView);
            } elseif ($endNumber === $lastPage) {
                $startNumber = max(1, $endNumber - $maxPagePerView + 1);
            }
        }

        return [
            'startNumber' => $startNumber,
            'endNumber' => $endNumber,
            'previousPage' => max(1, $page - 1),
            'nextPage' => min($lastPage, $page + 1),
        ];
    }

    public function getLimitInfo()
    {
        try {
            $userLimit = $this->getUserLimitData();

            if ($userLimit == null)
                throw new Exception("Falha ao obter limte de downloads! Contacte o suporte!");

            return [
                'actualLimit' => $userLimit->actual_limit,
                'totalLimit' => $userLimit->total_limit,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    #region PRIVATE 
    public function translateStockName($search_text)
    {
        try {
            $url = 'https://api.mymemory.translated.net/get';
            $idiomaOrigem = 'pt';
            $idiomaDestino = 'en';

            $url = 'https://api.mymemory.translated.net/get?q=' . $search_text . '&langpair=' . $idiomaOrigem . '|' . $idiomaDestino;

            $response = Http::get($url);

            if ($response["responseStatus"] != 200)
                throw new Exception("Falha ao realizar pesquisa por nome. Tente novamente mais tarde.");

            if ($response["quotaFinished"] == true)
                throw new Exception("Tradutor esgotado. Entre em contato com o suporte.");

            return $response['responseData']['translatedText'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    #endregion
}
