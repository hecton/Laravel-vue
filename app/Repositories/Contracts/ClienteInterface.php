<?php

namespace App\Repositories\Contracts;
use stdClass;

interface ClienteInterface
{
    public function create(array $data): stdClass;
    public function update(array $data): stdClass;
    public function getAll(string $filter = null): array;
    public function findOne(int|string $id): stdClass;
    public function delete(string|int $id): void;
}
