<?php

namespace App\Livewire\Laws;

use App\Models\Law;
use Livewire\Component;

class Roadmap extends Component
{
    public $lawId;

    public $law;

    public $type = 0;

    public $search;

    public function render()
    {

        $this->law =  Law::where('id', $this->lawId)
            ->with(['articles' => function ($query) {
                // Filter articles by the search term, if applicable.
                $query->when($this->search, function ($query) {
                    $query->where('article_name', 'like', '%' . $this->search . '%');
                })
                ->with(['items' => function ($itemQuery) {
                    $itemQuery->where('item_is_informative', false)
                        ->whereHas('maturity', function ($mquery) {
                            $mquery->where('maturity_level', '=', $this->type);
                        });
                }]);
            }])
            ->first();


        return view('livewire.laws.roadmap');
    }
}
