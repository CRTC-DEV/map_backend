<?php

namespace App\Http\Livewire\Map\Translations;

use App\Traits\LogsMapActivity;

use Livewire\Component;
use App\Models\Translations;
// use App\Models\TextContent;
// use App\Models\Languages;
class TranslationsListLive extends Component
{
    
    use LogsMapActivity;
public $translations;
    public function mount(){
        $this->logMapPageView('Translations List Page');

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
