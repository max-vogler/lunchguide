<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MenuRenderCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'menu:render';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renders the menu into an image file.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $arg = $this->argument('date');

        try {
            $date = Carbon::createFromFormat('Y-m-d', $this->argument('date'));
        } catch(Exception $exception) {
            $this->error('Invalid date "' . $this->argument('date') . '". YYYY-MM-DD format required.');
            return 1;
        }

        $date_formatted = url_date($date);
        $url = action('DailyMenuController@date', $date_formatted).'?print=1';
        $path = public_path() . '/img/menu/' . $date->format('Y/m/');
        $targetFile = $path . $date->format('d') . '.png';

        if(!is_dir($path) && !mkdir($path, 0777, true)) {
            $this->error('Could not create directory ' . $path);
            return 1;
        }

        if(file_exists($targetFile)) {
            unlink($targetFile);
        }

        $phantomjsPath = app_path() . '/phantomjs';

        // 2>&1 redirects stderr to stdout and suppresses phantomjs warnings showing up in the console
        shell_exec("$phantomjsPath/phantomjs $phantomjsPath/RenderMenu.js $url $targetFile 2>&1");

        if(file_exists($targetFile)) {
            $this->info($targetFile);
            return 0;
        } else {
            $this->error('Error while rendering!');
            return 1;
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        $today = \Carbon\Carbon::today()->toDateString();
        return array([
            'date', 
            InputArgument::OPTIONAL, 
            'Specifies a date for the daily menu. If empty, the menu of today is rendered.', 
            $today
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array();
    }

}
