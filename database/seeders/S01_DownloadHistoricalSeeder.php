<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DownloadHistorical;
use App\Models\User; // Certifique-se de importar o modelo User
use Carbon\Carbon;

class S01_DownloadHistoricalSeeder extends Seeder
{
    public function run()
    {
        // Obter todos os usuários
        $users = User::all();

        // Verifica se existem usuários
        if ($users->isEmpty()) {
            $this->command->info('Nenhum usuário encontrado. Crie usuários antes de rodar este seeder.');
            return;
        }

        // Cria registros de histórico de download para cada usuário
        foreach ($users as $user) {
            DownloadHistorical::factory()->create([
                'user_id' => $user->id, // Associar o histórico ao usuário
                'image_path' => 'path/to/image/' . $user->id . '/image_' . rand(1, 100) . '.jpg',
                'image_name' => 'Image ' . rand(1, 100),
                'image_bank' => ['free', 'stock'][array_rand(['free', 'stock'])], // Seleciona aleatoriamente entre 'free' e 'stock'
                'date' => Carbon::now()->subDays(rand(1, 30)), // Data aleatória nos últimos 30 dias
            ]);
        }
    }
}
