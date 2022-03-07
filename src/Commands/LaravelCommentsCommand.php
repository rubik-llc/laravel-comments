<?php

namespace Rubik\LaravelComments\Commands;

use Illuminate\Console\Command;
use function Pest\Laravel\artisan;

class LaravelCommentsCommand extends Command
{
    public $signature = 'laravel-comments:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment("
  ____        _     _ _
 |  _ \ _   _| |__ (_) | __
 | |_) | | | | '_ \| | |/ /
 |  _ <| |_| | |_) | |   <
 |_| \_\\\\__,_|_.__/|_|_|\_\

");


        if ($this->confirm('Do you wish to run migrations?', true)) {
            $this->call('migrate');
        }



//        $name = $this->ask('What is your name?');
//        $name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);
//        $this->line('Display this on the screen');
//        $name = $this->choice(
//            'What is your name?',
//            ['Taylor', 'Dayle'],
//        );
//        $this->info($name);

        return self::SUCCESS;
    }
}
