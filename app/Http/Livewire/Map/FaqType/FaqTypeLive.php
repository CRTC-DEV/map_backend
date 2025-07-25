<?php

namespace App\Http\Livewire\Map\FaqType;

use App\Traits\LogsMapActivity;

use App\Models\Map\FaqType;
use Livewire\Component;

class FaqTypeLive extends Component
{
    
    
    use LogsMapActivity;
public $faq_type;
    public $item_title;
    public function mount(){
        $this->logMapPageView('Faq Type Page');

        // $obj_item = new ItemDescription();
        $obj_faq_type_device_touchs= new FaqType();
        $this->faq_type = $obj_faq_type_device_touchs->getAllFaqType();
        // dd($this->faq_type);
    }

    public function render()
    {
        return view('livewire.map.faq-type.faq_type_list');
    }
}
