<?php

namespace App\Http\Livewire\Map\Faq;

use App\Models\Map\Faq;
use Livewire\Component;

class FaqLive extends Component
{
    
    public $faq;
    public $item_title;
    public function mount(){

        $obj_faq_device_touchs= new Faq();
        $this->faq = $obj_faq_device_touchs->getAllFaq();
        // dd($this->faq);
    }

    public function render()
    {
        return view('livewire.map.faq.faq_list');
    }
}
