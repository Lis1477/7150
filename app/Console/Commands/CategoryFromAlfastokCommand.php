<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CategoryFromAlfactok;


class CategoryFromAlfastokCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление категорий и товаров из БД Альфасток';

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
        CategoryFromAlfactok::catSynchro();
        $this->info('Категории и товары обновлены!');
    }
}
