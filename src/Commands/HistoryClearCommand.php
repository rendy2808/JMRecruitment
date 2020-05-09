<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryClearCommand extends Command
{
    /**
     * @var string
     */
    protected $signature =  'history:clear';

    /**
     * @var string
     */
    protected $description = 'Clear saved history';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $deleted_history = $this->clear_history();
        if($deleted_history) {
            $this->comment(sprintf('History cleared!'));
        }
    }

    private function clear_history()
    {
        $history_storage = 'history_list.log';
        if(file_exists($history_storage)) {
            $history_storage = fopen("history_list.log", "w");
            fwrite($history_storage, '');
            fclose($history_storage);
            return true;
        } else {
            return false;
        }
    }
}
