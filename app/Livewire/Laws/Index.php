<?php

namespace App\Livewire\Laws;

use App\Repositories\Law\LawRepository;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    private $lawRepository;


    #[Url(history: true)]
    public $search = 'valor';

    public $laws = [];

    public function boot(LawRepository $lawRepository)
    {
        $this->lawRepository = $lawRepository;
    }


    public function render()
    {
        $this->laws = $this->lawRepository->all();

        return view('livewire.laws.index');
    }
}
