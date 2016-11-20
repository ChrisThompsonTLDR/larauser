<?php

namespace Christhompsontldr\Larauser;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Christhompsontldr\Larauser\Models\Traits\Larauser;
use Traitor\Traitor;

class AddTraitCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larauser:add-trait';

    /**
     * Trait added to User model
     *
     * @var string
     */
    protected $targetTrait = Larauser::class;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $userModel = $this->getUserModel();

        if (! class_exists($userModel)) {
            $this->error("Class $userModel does not exist.");
            return;
        }

        if ($this->exists()) {
            $this->error("Class $userModel already uses Larauser trait.");
            return;
        }

        Traitor::addTrait($this->targetTrait)->toClass($userModel);

        $this->info("Larauser trait added successfully");
    }

    /**
     * @return bool
     */
    protected function exists()
    {
        return in_array(Larauser::class, class_uses($this->getUserModel()));
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return "Add Larauser trait to {$this->getUserModel()} class";
    }

    /**
     * @return string
     */
    protected function getUserModel()
    {
        return config('auth.providers.users.model', 'App\User');
    }
}