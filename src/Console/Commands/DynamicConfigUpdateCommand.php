<?php

namespace zukyDev\DynamicConfig\Console\Commands;

use Illuminate\Console\Command;
use zukyDev\DynamicConfig\Services\DynamicConfigService;

class DynamicConfigUpdateCommand extends Command
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
    protected $signature =
        'dynamic-config:update {name} {--name=} {--type=} {--enums=*} {--value=} {--default-value=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Dynamic Config';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $config = $this->service->find($this->argument('name'));

        $config = $this->service->update($this->argument('name'), [
            $this->option('name') ?? $config->name,
            $this->option('type') ?? $config->type,
            $this->option('enums'),
            $this->option('value'),
            $this->option('default-value'),
        ]);

        $this->line("DynamicConfig: Updated config with name: $config->name");
    }
}
