<?php

namespace Christhompsontldr\Larauser;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larauser:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup migration Larauser';

    /**
     * Commands to call with their description
     *
     * @var array
     */
    protected $calls = [
        'larauser:migrations' => 'Creating migrations',
        'larauser:add-trait'  => 'Adding Larauser trait to User model',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        foreach ($this->calls as $command => $info) {
            $this->line(PHP_EOL . $info);
            $this->call($command);
        }
    }
}