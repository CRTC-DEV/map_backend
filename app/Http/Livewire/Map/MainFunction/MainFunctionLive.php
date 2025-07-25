<?php

namespace App\Http\Livewire\Map\MainFunction;

use App\Traits\LogsMapActivity;

use App\Models\Map\MainFunction;
use Livewire\Component;

class MainFunctionLive extends Component
{
    
    use LogsMapActivity;
public $item_type;
    public $mainfunction;
    public $item_title;
    public function mount(){
        $this->logMapPageView('Main Function Page');

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
