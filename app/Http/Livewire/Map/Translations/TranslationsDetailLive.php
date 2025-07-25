<?php

namespace App\Http\Livewire\Map\Translations;

use App\Traits\LogsMapActivity;

use Livewire\Component;
use App\Models\Languages;
use App\Models\TextContent;
use App\Models\Translations;

class TranslationsDetailLive extends Component
{
    
    use LogsMapActivity;
public $message;
    public $translations;
    public $translations_textcontent_id;
    public $translations_language_id;
    public $languages;
    public $text_content;
    public $translationsStatus;
    
    // public $languages;
    // public $text_content;
    public function rules()
    {
        return [
           'translations.TextContentId' => 'required',
            'translations.LanguageId' => 'required|numeric',
            'translations.Translation' => 'required',
            'translations.Status' => 'required'
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function mount($id)
    {
        $this->logMapPageView('Translations Detail Page');
   
        // $this->translations_id = $id;

        [$this->translations_textcontent_id, $this->translations_language_id] = explode(",", $id);

        $obj_translations = new Translations();
        $this->translations = $obj_translations->getTranslationsById($this->translations_textcontent_id, $this->translations_language_id);
        // $this->translationsStatus = $this->translations->Status;
        // dd($this->translationsStatus);
    }

    public function render()
    {
        $obj_text_content = new TextContent();
        $obj_languages = new Languages();
        $this->languages = $obj_languages->getAllLanguages();
        $this->text_content = $obj_text_content->getAllTextContent();
        return view('livewire.map.translations.translations_edit');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Translations Detail');

        // dd($this->map_item);
        $this->validate();
        // $this->translation['Status'] = $this->translationsStatus;
        $obj_translations = new Translations();
        //dd($this->translations);
        $obj_translations->updateTranslations($this->translations, $this->translations_textcontent_id, $this->translations_language_id);
        // $this->translations->save();
        
        return guarded_redirect('translations','admin.translations')->with(['message' => __('Updated Successfull'), 'status' => 'success']);

    }

    // public function delete()
    // {   
    //     $this->translations->Status = DELETED_FLG;
    //     $obj_translations = new Translations();
    //     $obj_translations->deleteTranslations(
    //         ['Status' => 3 ], $this->translations_textcontent_id, $this->translations_language_id);
        
    //     return redirect()->route('translations')->with(['message' => __('Deleted Succesfull'), 'status' => 'success']);
    // }
}