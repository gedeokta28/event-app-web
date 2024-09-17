<?php

namespace App\Repositories\Base;

interface RepositoryContract
{

    public function getAll(): array;

    public function getById(): array;
}
