<?php

namespace zukyDev\DynamicConfig\Console\Commands;

use Illuminate\Console\Command;
use zukyDev\DynamicConfig\Services\DynamicConfigService;

class DynamicConfigStoreCommand extends Command
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
    protected $signature = 'dynamic-config:store {name} {type} {--enums=*} {--value=} {--default-value=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores Dynamic Config';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $config = $this->service->store([
            $this->argument('name'),
            $this->argument('type'),
            $this->option('enums'),
            $this->option('value'),
            $this->option('default-value'),
        ]);

        $this->line("DynamicConfig: Created config with name: $config->name");
    }
}
