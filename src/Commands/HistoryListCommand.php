<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature =  'history:list {commands?* : Filter the history by commands}';

    /**
     * @var string
     */
    protected $description = 'Show calculator history';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $commands = $this->argument('commands');
        $history_storage = 'history_list.log';
        if(file_exists($history_storage)) {
            $history_headers = $this->getHeaders();
            $history_list = $this->mappingLogs($history_storage, $commands);
            if(count($history_list) < 1) {
                $this->comment(sprintf('History is empty.'));
            } else {
                $this->table($history_headers, $history_list);
            }
        }
    }

    private function getHeaders()
    {
        $header_list = array(
            'No',
            'Command',
            'Description',
            'Result',
            'Output',
            'Time'
        );

        return $header_list;
    }

    private function mappingLogs($history_storage, $commands)
    {
        $file_storage = fopen($history_storage, 'r');
        $key = 0;
        $history = array();

        if($file_storage) {
            while($row = fgets($file_storage)) 
            {
                $data_row = explode(",", $row);
                if(count($commands) > 0) {
                    $data_history = array(
                        'No' => $key + 1,
                        'Command' => $data_row[0],
                        'Description' => $data_row[1],
                        'Result' => $data_row[2],
                        'Output' => $data_row[3],
                        'Time' => $data_row[4]
                    );
                    if(in_array($data_row[0], $commands)) {
                        array_push($history, $data_history);
                    }
                    $key = $key + 1;
                } else {
                    $data_history = array(
                        'No' => $key + 1,
                        'Command' => $data_row[0],
                        'Description' => $data_row[1],
                        'Result' => $data_row[2],
                        'Output' => $data_row[3],
                        'Time' => $data_row[4]
                    );

                    array_push($history, $data_history);
                    $key = $key + 1;
                }
            }
        }
        return $history;
        
    }
}
