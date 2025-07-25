<?php

namespace App\Http\Livewire\Map\Languages;

use App\Traits\LogsMapActivity;

use App\Models\Languages;
use Livewire\Component;

class LanguagesAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $languages;

    public function rules()
    {
        return [
            'languages.Status' => 'required|numeric',
            'languages.Name' => 'required',
        ];
    }

    public function messages()
    {
        return [
    
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Languages Add Page');


    }

    public function render()
    {
        return view('livewire.map.languages.languages_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Languages Add');

        
        $this->validate();
        // dd($this->item_title);
        $obj_languages = new Languages();
        $obj_languages->insertLanguage($this->languages);
        
        return guarded_redirect('languages', 'amin.languages')->with(['message' => __('Insert Successfull'), 'status' => 'success']);

    }
}
