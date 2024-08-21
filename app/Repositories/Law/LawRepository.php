<?php

namespace App\Repositories\Law;

use App\Models\Law;

class LawRepository implements LawRepositoryInterface
{
    public function all()
    {
        return Law::all();
    }

    public function create(array $data)
    {
        return Law::create($data);
    }

    public function update($id, array $data)
    {
        return Law::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Law::findOrFail($id)->delete();
    }

    public function find($id)
    {
        return Law::findOrFail($id);
    }

}
