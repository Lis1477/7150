<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ItemsFromAlfactok;

class ItemFromAlfastokCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление товаров из БД Альфасток';

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
     * @return mixed
     */
    public function handle()
    {
        ItemsFromAlfactok::itemSynchro();
        $this->info('Синхронизация с Альфа товарами произведена');
    }
}
