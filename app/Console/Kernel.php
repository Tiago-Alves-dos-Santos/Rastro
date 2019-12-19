<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
//classes de tarefas
//classes
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
class Kernel extends ConsoleKernel
{
    /**
     * Aq vc coloca o nome da classe ::class
     *
     * NomeDaClasse::class
     * 
     * vc pode colocar n classes aq, mas nao esqueça de colocar o use da classe no
     * começo do arquivo
     * 
     * NomeDaClasse2::class
     * NomeDaClasse1::class
     * NomeDaClasse3::class
     */
    protected $commands = [
        
    ];

    /**
     * Aq vc ira chamar a classe desejada juntamente com o nome do comando q vc deu 
     */
    protected function schedule(Schedule $schedule)
    {
        //comando que verfica usuarios logados a cada 15min
        
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
