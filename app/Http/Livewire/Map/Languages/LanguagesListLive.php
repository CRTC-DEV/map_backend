<?php

namespace App\Http\Livewire\Map\Languages;

use App\Traits\LogsMapActivity;

use App\Models\Languages;
use Livewire\Component;

class LanguagesListLive extends Component
{
    
    use LogsMapActivity;
public $languages;
    public function mount(){
        $this->logMapPageView('Languages List Page');

        // $obj_item = new ItemTitle();
        $obj_languages= new Languages();
        $this->languages = $obj_languages->getAllLanguages();
        // dd($this->map_item);
    }
    public function render()
    {   
        return view('livewire.map.languages.languages_list');
    }
}
