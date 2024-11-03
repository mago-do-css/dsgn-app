<?php
namespace Database\Seeders;

use App\Enums\BancoImagemEnum;
use App\Enums\StockTypeEnum;
use Illuminate\Database\Seeder;
use App\Models\DownloadHistory; 
use Carbon\Carbon; 

class S01_DownloadHistorySeeder extends Seeder
{
    public function run()
    {

        $datas = [
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-301744478.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2292916287.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2504823041.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2009038448.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2285967965.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
               'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-281493026.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
               'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-58072690.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2529825953.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::vector->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-58072690.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::vector->value,
            ],
            [
                'url' => 'https://img.freepik.com/fotos-premium/banner-horizontal-para-o-site-que-enfatiza-o-desenvolvimento-pessoal-e-a-felicidade_1096167-150672.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/retrato-de-mulher-afro-americana-rindo_58466-9094.jpg?w=1480',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/maquete-de-caixa-de-pizza-aberta_58466-11163.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/midia-social-independencia-do-brasil-independencia-do-brasil_450139-2164.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/midias-sociais-para-a-data-comemorativa_450139-436.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/um-sinal-par…beleza-e-exibido-em-uma-vitrine_1306097-41802.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/papelaria-mock-up-projeto_1307-29.jpg?w=1060',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/duas-canecas-com-citacoes_1289061-2784.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ],  
           
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-301744478.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2292916287.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2504823041.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2009038448.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2285967965.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
               'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-281493026.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
               'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-58072690.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2529825953.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::vector->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-58072690.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::vector->value,
            ],
            [
                'url' => 'https://img.freepik.com/fotos-premium/banner-horizontal-para-o-site-que-enfatiza-o-desenvolvimento-pessoal-e-a-felicidade_1096167-150672.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/retrato-de-mulher-afro-americana-rindo_58466-9094.jpg?w=1480',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/maquete-de-caixa-de-pizza-aberta_58466-11163.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/midia-social-independencia-do-brasil-independencia-do-brasil_450139-2164.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/midias-sociais-para-a-data-comemorativa_450139-436.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/um-sinal-par…beleza-e-exibido-em-uma-vitrine_1306097-41802.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/papelaria-mock-up-projeto_1307-29.jpg?w=1060',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/duas-canecas-com-citacoes_1289061-2784.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ],  
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-301744478.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2292916287.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2504823041.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2009038448.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2285967965.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
               'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-281493026.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
               'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-58072690.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::image->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-2529825953.jpg',
               'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::vector->value,
            ],
            [
                'url' => 'https://image.shutterstock.com/image-vector/-250nw-58072690.jpg',
                'origin' => BancoImagemEnum::shutterstock->value,
                'type'=>  StockTypeEnum::vector->value,
            ],
            [
                'url' => 'https://img.freepik.com/fotos-premium/banner-horizontal-para-o-site-que-enfatiza-o-desenvolvimento-pessoal-e-a-felicidade_1096167-150672.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/retrato-de-mulher-afro-americana-rindo_58466-9094.jpg?w=1480',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/maquete-de-caixa-de-pizza-aberta_58466-11163.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/midia-social-independencia-do-brasil-independencia-do-brasil_450139-2164.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/midias-sociais-para-a-data-comemorativa_450139-436.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/um-sinal-par…beleza-e-exibido-em-uma-vitrine_1306097-41802.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
            [
                'url' => 'https://img.freepik.com/psd-premium/papelaria-mock-up-projeto_1307-29.jpg?w=1060',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::psd->value,
            ], 
            [
                'url' => 'https://img.freepik.com/fotos-premium/duas-canecas-com-citacoes_1289061-2784.jpg',
                'origin' => BancoImagemEnum::freepik->value,
                'type'=>  StockTypeEnum::image->value,
            ], 
          
           
        ];

        // Cria registros de histórico de download para cada usuário
        foreach ($datas as $data) {
            DownloadHistory::create([
                'user_id' => 1,  
                'stock_type' => $data['type'],
                'stock_origin' => $data['origin'], 
                'stock_url' => $data['url'], 
                'date' => Carbon::now()->subDays(rand(1, 15)), // Data aleatória nos últimos 30 dias
            ]);
        }
    }
}
