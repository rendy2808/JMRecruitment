<?php

return [
    // TODO : Add list of commands here
    'add' => Jakmall\Recruitment\Calculator\Commands\AddCommand::class,
    'subtract' => Jakmall\Recruitment\Calculator\Commands\SubtractCommand::class,
    'multiply' => Jakmall\Recruitment\Calculator\Commands\MultiplyCommand::class,
    'divide' => Jakmall\Recruitment\Calculator\Commands\DivideCommand::class,
    'pow' => Jakmall\Recruitment\Calculator\Commands\PowCommand::class,
    'history:list' => Jakmall\Recruitment\Calculator\Commands\HistoryListCommand::class,
];
