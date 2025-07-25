<?php

namespace App\Http\Livewire\Map\GroupFunction;

use App\Models\Map\GroupFunction;
use Livewire\Component;

class GroupFunctionLive extends Component
{
    public $item_type;
    public $GroupFunction;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_GroupFunction_device_touchs= new GroupFunction();
        $this->GroupFunction = $obj_GroupFunction_device_touchs->getAllGroupFunctions();
        // dd($this->GroupFunction);
    }

    public function render()
    {
        return view('livewire.map.group-function.group_function_list');
    }
}
