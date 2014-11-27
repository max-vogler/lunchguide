<?php

class GitHubController extends BaseController {

    public function pull() {
        if(!Config::get('app.secrets.github') || Input::get('secret') != Config::get('app.secrets.github')) {
            App::abort(401);
        }

        echo "<pre>";
        $this->execute('git reset --hard HEAD && git pull origin master');
        $this->execute('composer update');
        $this->execute('composer dump-autoload');
    }

    protected function execute($command, $path = '') {
        $fullPath = base_path() . $path;
        $command = "cd $fullPath && $command";
        echo "$ $command\n";
        echo shell_exec($command)."\n";
    }

}
