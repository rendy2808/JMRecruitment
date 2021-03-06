<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DivideCommand extends Command
{
    /**
     * @var string
     */
    protected $signature =  'divide {numbers* : The numbers to be divided}';

    /**
     * @var string
     */
    protected $description = 'Divide all given Numbers';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $numbers_invalid = $this->validateNumbers($numbers);
        if($numbers_invalid) {
            $this->comment(sprintf('Numbers only'));
        } else {
            $description = $this->generateCalculationDescription($numbers);
            $result = $this->calculateAll($numbers);
            $output = sprintf('%s = %s', $description, $result);
            $this->add_history('divide', $description, $result, $output);
            $this->comment($output);
        }
    }

    public function validateNumbers($arr) {
        $char = array_merge(range('A', 'Z'), range('a', 'z'));
        $valid = !empty(array_intersect($arr, $char));
        return $valid;
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '/';
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 / $number2;
    }

    private function add_history($command, $description, $result, $output)
    {
        $created_at = Carbon::now()->addHour(7);
        $history_storage = fopen("history_list.log", "a");
        $history_format = $command.",".$description.",".$result.",".$output.",".$created_at."\n";
        fwrite($history_storage, $history_format);
        fclose($history_storage);
    }
}
