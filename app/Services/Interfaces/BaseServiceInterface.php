<?php

namespace App\Services\Interfaces;

interface BaseServiceInterface
{
    public function getAll(array $filters = []);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
} 