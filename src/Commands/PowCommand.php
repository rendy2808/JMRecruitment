<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PowCommand extends Command
{
    /**
     * @var string
     */
    protected $signature =  'pow {base : The base number} {exp : The exponent number}';

    /**
     * @var string
     */
    protected $description = 'Exponent all given Numbers';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $base = $this->argument('base');
        $exponent = $this->argument('exp');
        $numbers = array($base, $exponent);
        $numbers_invalid = $this->validateNumbers($numbers);
        if($numbers_invalid) {
            $this->comment(sprintf('Numbers only'));
        } else {
            $description = $this->generateCalculationDescription($numbers);
            $result = pow($base, $exponent);

            $this->comment(sprintf('%s = %s', $description, $result));
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
        return '^';
    }
}
