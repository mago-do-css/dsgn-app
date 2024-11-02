<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Enums\BancoImagemEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLimits;
use App\Models\DownloadHistory;
use Carbon\Carbon;

class HistoryService
{
    public function getDownloadHistory($request)
    {
        try {

            $getHistory = DownloadHistory::query();

            //TODO: criar uma documentação para explicar como usar isso
            //obtendo o id do usuário através do middleware que está autenticado
            $getHistory->where('user_id', $request->user()->id);

            if (!empty($request->images_origin)) {
                $getHistory->whereIn('image_origin', array_map(function ($image_bank) {
                    return BancoImagemEnum::from($image_bank)->name;
                }, $request->images_origin));
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');

                $getHistory->whereBetween('date', [$startDate, $endDate]);
            }

            // Paginação - ajusta o número de itens por página conforme necessário. Por exemplo, 12 itens por página
            $perPage = 12;
            $getHistory = $getHistory->paginate($perPage);

            $lastPage = $getHistory->lastPage();

            return [
                'historyData' => $getHistory,
                'lastPage' => $lastPage,
                'selectedOptions' => $request->images_origin,
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
            'nextPage' =>min($lastPage, $page + 1),
        ];
    }  
}