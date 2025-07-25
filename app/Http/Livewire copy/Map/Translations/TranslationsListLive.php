<?php

namespace App\Http\Livewire\Map\Translations;

use Livewire\Component;
use App\Models\Translations;
// use App\Models\TextContent;
// use App\Models\Languages;
class TranslationsListLive extends Component
{
    public $translations;
    public function mount(){
        // $obj_item = new ItemTitle();
        $obj_translations= new Translations();
        $this->translations = $obj_translations->getAllTranslations();
        // dd($this->translations);
    }
    public function render()
    {   
        return view('livewire.map.translations.translations_list');
    }
}
