<?php

namespace zukyDev\DynamicConfig\Services;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use zukyDev\DynamicConfig\Models\DynamicConfig;
use zukyDev\DynamicConfig\Repositories\DynamicConfigRepository;

class DynamicConfigService
{
    private bool $isInitialized = false;

    public function __construct(
        private DynamicConfigRepository $repository
    )
    {
        try {
            $this->init();
        } catch (Exception $e) {}
    }

    private function init(): void
    {
        if (!$this->isInitialized) {
            $dynamicConfigs = $this->repository
                ->getAll()
                ->keyBy('name')
                ->transform(function (DynamicConfig $config) {
                    return $config->value;
                })
                ->toArray();

            if (!empty($dynamicConfigs)) {
                config($dynamicConfigs);
            }

            $this->isInitialized = true;
        }
    }

    public function all(): Collection
    {
        return $this->repository->getAll();
    }

    public function find(string $name): DynamicConfig
    {
        return $this->repository->find($name);
    }

    public function store(array $data): DynamicConfig
    {
        return $this->repository->store($data);
    }

    public function update(string $name, array $data): DynamicConfig
    {
        return $this->repository->update($name, $data);
    }

    public function destroy(string $name): void
    {
        $this->repository->destroy($name);
    }
}
