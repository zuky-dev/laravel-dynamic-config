<?php

namespace zukyDev\DynamicConfig\Console\Commands;

use Illuminate\Console\Command;
use zukyDev\DynamicConfig\Services\DynamicConfigService;

class DynamicConfigDestroyCommand extends Command
{
    public function __construct(
        private DynamicConfigService $service
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-config:destroy {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroys Dynamic Config';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->service->destroy($name);

        $this->line("DynamicConfig: Updated config with name: $name");
    }
}
