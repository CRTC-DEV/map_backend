<?php

namespace App\Http\Livewire\Map\Languages;

use App\Traits\LogsMapActivity;

use App\Models\Languages;
use Livewire\Component;

class LanguagesDetailLive extends Component
{
    
    use LogsMapActivity;
public $message;
    public $languages;
    public $languages_id;
    public function rules()
    {
        return [
        //    'languages.Zone' => 'required|numeric',
        //     'languages.Floor' => 'required|numeric',
            'languages.Status' => 'required|numeric',
            'languages.Name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'map_item.CadId.required' => __('zzz'),
            // 'map_item.CadId.numeric' => __('zzz'),
        ];
    }

    public function mount($id)
    {
        $this->logMapPageView('Languages Detail Page');

        $this->languages_id = $id;
        $obj_languages = new Languages();
        $this->languages = $obj_languages->getLanguageById($id);
        // dd($this->map_item);
    }

    public function render()
    {
        return view('livewire.map.languages.languages_edit');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Languages Detail');

        // dd($this->map_item);
        $this->validate();
        
        $obj_languages = new Languages();
        // $obj_map_item->insertMapItem($this->map_item);
        $obj_languages->updateLanguage($this->languages, $this->languages_id);
        // $this->languages->save();
        
        return guarded_redirect('languages', 'amin.languages')->with(['message' => __('Updated Successfull'), 'status' => 'success']);

    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Languages Detail');
   
        $this->languages->Status = DELETED_FLG;
        $obj_languages = new Languages();
        $obj_languages->deleteLanguage(
            ['Status' => 3 ], $this->languages_id);
        
        return guarded_redirect('languages', 'amin.languages')->with(['message' => __('Deleted Succesfull'), 'status' => 'success']);
    }
}