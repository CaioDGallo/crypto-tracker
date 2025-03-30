<?php
declare(strict_types=1);

namespace App\Logger;

class StdoutLoggerFactory
{
    public function __invoke()
    {
        return Log::get('sys');
    }
}
