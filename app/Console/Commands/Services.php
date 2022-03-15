<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;

class services extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd((new UserService)->store([
            'nome_completo' => 'Leonardo Neves',
            'documento' => '44692966866',
            'senha' => '123456',
            'tipo' => 'ADM',
            'email' => 'brineves.leonardo@gmail.com',
            'telefone' => '14991512121',
            'id_filial' => '1',
            'acesso_modulos' => '1'
        ]));
    }
}