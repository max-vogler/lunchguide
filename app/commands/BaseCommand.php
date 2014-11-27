<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\BufferedOutput;

class BaseCommand extends Command {

    protected function callCommand($command, $args = []) {
        $buffer = new BufferedOutput;
        $return = Artisan::call($command, $args, $buffer);
        $output = trim($buffer->fetch());
        return [$return, $output];
    }

}
