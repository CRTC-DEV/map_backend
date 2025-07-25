<?php

namespace App\Http\Livewire\Map\MainFunction;

use App\Models\Map\MainFunction;
use Livewire\Component;

class MainFunctionLive extends Component
{
    public $item_type;
    public $mainfunction;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj= new MainFunction();
        $this->mainfunction = $obj->getAllFunction();
        // dd($this->Function);
    }

    public function render()
    {
        return view('livewire.map.mainfunction.mainfunction_list');
    }
}
