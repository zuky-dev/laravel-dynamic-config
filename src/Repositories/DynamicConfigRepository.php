<?php

namespace zukyDev\DynamicConfig\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use zukyDev\DynamicConfig\Models\DynamicConfig;

class DynamicConfigRepository
{
    public function __construct(
        private DynamicConfig $model
    )
    {}

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function find(string $name): ?DynamicConfig
    {
        return $this->model->findOrFail($name);
    }

    public function store(array $data): DynamicConfig
    {
        if ($this->validate($data)) {
            return $this->model->store($data);
        }

        throw new Exception('');
    }

    public function update(string $name, array $data): DynamicConfig
    {
        $config = $this->find($name);

        if ($config && $this->validate($data, $config)) {
            $config->update($data);

            return $config;
        }

        throw new Exception('');
    }

    public function destroy(string $name): void
    {
        $this
            ->find($name)
            ?->delete();
    }

    private function validate(array $data, DynamicConfig $config = null): bool
    {
        $valueRules = array_merge(['nullable'],
            match($data['type']) {
                DynamicConfig::TYPE_BOOLEAN => ['boolean'],
                DynamicConfig::TYPE_INTEGER => ['numeric', 'integer'],
                DynamicConfig::TYPE_FLOAT => ['numeric'],
                DynamicConfig::TYPE_DATETIME => ['date'],
                DynamicConfig::TYPE_JSON => ['json'],
                DynamicConfig::TYPE_ENUM => [Rule::in($data['type'])],
                DynamicConfig::TYPE_STRING => [],
                default => []
            }
        );

        $validator = Validator::make($data, [
            'name' => [
                'required',
                Rule::unique('dynamic_configs', 'name')->ignore($config?->name)
            ],
            'type' => [
                'required',
                Rule::in(DynamicConfig::TYPES)
            ],
            'enums' => [
                'nullable',
                'array'
            ],
            'value' => $valueRules,
            'default_value' => $valueRules
        ]);

        return !$validator->fails();
    }
}
