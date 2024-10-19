<?php

namespace App\Repositories\Law;

interface LawRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function find($id);
}
