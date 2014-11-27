<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \SammyK\FacebookQueryBuilder\FacebookQueryBuilderException;
use SammyK\FacebookQueryBuilder\FQB;

class MenuPostCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'menu:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Posts an image to Facebook pages.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $page = FbPage::first();
        $message = $this->argument('message');
        $image = $this->argument('image');

        if(!$page) {
            $this->error('No Facebook page found!');
            return 10;
        }

        if(!$page->hasValidPermissions()) {
            $this->error('Facebook page has no valid permissions!');
            return 11;
        }

        if(!file_exists($image)) {
            $this->error('Image ' . $image . ' not found!');
            return 12;
        }

        try {
            $result = $page->postMessageWithImage($message, $image);

            if($result && $result['id']) {
                $link = (new FQB)->object($result['id'])->get(['link'])['link'];
                $this->info($link);
                return 0;
            } else {
                $this->error('Error while posting!');
                return 13;
            }
        } catch(FacebookQueryBuilderException $exception) {
            $this->error($exception->getMessage());
            return 14;
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            [
                'message', 
                InputArgument::REQUIRED, 
                'The message to be posted.'
            ], [
                'image', 
                InputArgument::REQUIRED, 
                'The image file to be posted.'
            ], 
        );
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
