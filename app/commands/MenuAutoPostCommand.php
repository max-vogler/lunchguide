<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \SammyK\FacebookQueryBuilder\FacebookQueryBuilderException;
use SammyK\FacebookQueryBuilder\FQB;
use Symfony\Component\Console\Output\BufferedOutput;

class MenuAutoPostCommand extends BaseCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'menu:auto-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renders, captions and posts todays menu image to Faceook.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $date = Carbon::parse($this->argument('date'));

        try {
            $date = Carbon::createFromFormat('Y-m-d', $this->argument('date'));
            list($returnCode, $output) = $this->callCommand('menu:render', ['date' => $date->toDateString()]);
        } catch(Exception $exception) {
            $returnCode = 31;
            $output = 'Invalid date "' . $this->argument('date') . '". YYYY-MM-DD format required.';
        }

        // Carbon::createFromFormat() uses the current time
        // which makes Eloquent::where('date', \Carbon) fail!
        // ==> remove time part manually -_-
        $date->hour(0)->minute(0)->second(0);

        if($returnCode == 0) {
            $image = $output;
            $randomMeal = \Meal::orderByRaw("RAND()")
                ->where('date', $date)
                ->where('featured', true)
                ->first();

            $line = $randomMeal ? 'lunchguide.caption-regular' : 'lunchguide.caption-empty';
            $message = trans($line, [
                'date' => $date->formatLocalized('%e. %B'), 
                'meal' => $randomMeal ? $randomMeal->name : ''
            ]);

            list($returnCode, $output) = $this->callCommand('menu:post', ['message' => $message, 'image' => $image]);
        }

        $returnCode == 0 ? $this->info($output) : $this->error($output);
        return $returnCode;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        $today = Carbon::today()->toDateString();
        return array([
            'date', 
            InputArgument::OPTIONAL, 
            'Specifies a date. If empty, todays menu is posted.', 
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
