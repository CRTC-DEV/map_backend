<?php

namespace App\Http\Livewire\Map\TextContent;

use App\Models\Languages;
use App\Models\TextContent;
use Livewire\Component;

class TextContentAddLive extends Component
{

    public $message;
    public $text_content;
    public $languages;
    public function rules()
    {
        return [
            'text_content.OriginalText' => 'required',
            'text_content.OriginalLanguageId' => 'required|numeric',
            'text_content.Status' => 'required|numeric',

        ];
    }

    public function messages()
    {
        return [
    
        ];
    }

    public function mount()
    {

    }

    public function render()
    {
        $obj_language = new Languages();
        $this->languages = $obj_language->getAllLanguages();
        return view('livewire.map.text-content.text_content_add');
    }

    public function save(){
        
        $this->validate();
        // dd($this->item_title);
        $obj_text_content = new TextContent();
        $obj_text_content->insertTextContent($this->text_content);
        
        return guarded_redirect('text-content', 'admin.text-content')->with(['message' => __('Insert Successfull'), 'status' => 'success']);

    }
}
