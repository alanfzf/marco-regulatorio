<?php

namespace App\Repositories\Law;

use App\Models\Law;
use Illuminate\Support\Facades\Auth;

class LawRepository implements LawRepositoryInterface
{
    public function all()
    {
        $user = Auth::user();
        $law = Law::withCount([
            'articles',
            'items',
            'items as complete_items_count' => function ($query) {
                $query->where('item_is_informative', true)
                    ->orWhereHas('maturity', function ($mquery) {
                        $mquery->where('maturity_level', '>=', 1);
                    });
            },
        ])->whereHas('managers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return $law;
    }

    public function create(array $data): Law
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
