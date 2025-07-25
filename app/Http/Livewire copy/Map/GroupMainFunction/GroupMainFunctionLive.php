<?php

namespace App\Http\Livewire\Map\GroupMainFunction;

use App\Models\Map\GroupMainFunction;
use Livewire\Component;

class GroupMainFunctionLive extends Component
{
    public $item_type;
    public $group_mainfunction;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj= new GroupMainFunction();
        $this->group_mainfunction = $obj->getGroupMainFunction();
        //dd($this->group_mainfunction);
    }

    public function render()
    {
        return view('livewire.map.group-mainfunction.group_mainfunction_list');
    }
}
