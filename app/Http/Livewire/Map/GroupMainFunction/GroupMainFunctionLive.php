<?php

namespace App\Http\Livewire\Map\GroupMainFunction;

use App\Traits\LogsMapActivity;

use App\Models\Map\GroupMainFunction;
use Livewire\Component;

class GroupMainFunctionLive extends Component
{
    
    use LogsMapActivity;
public $item_type;
    public $group_mainfunction;
    public $item_title;
    public function mount(){
        $this->logMapPageView('Group Main Function Page');

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
