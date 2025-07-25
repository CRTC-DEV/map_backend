<?php

namespace App\Http\Livewire\Map\TextContent;

use App\Models\TextContent;
use App\Models\Languages;
use Livewire\Component;


class TextContentDetailLive extends Component
{
    public $message;
    public $text_content;
    public $text_content_id;
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
            // 'map_item.CadId.required' => __('zzz'),
            // 'map_item.CadId.numeric' => __('zzz'),
        ];
    }

    public function mount($id)
    {
        $this->text_content_id = $id;
        $obj_text_content = new TextContent();
        $this->text_content = $obj_text_content->getTextContentById($id);
        // dd($this->map_item);
    }

    public function render()
    {
        $obj_language = new Languages();
        $this->languages = $obj_language->getAllLanguages();
        return view('livewire.map.text-content.text_content_edit');
    }

    public function save(){
        // dd($this->map_item);
        $this->validate();
        
        $obj_text_content = new TextContent();
        // $obj_map_item->insertMapItem($this->map_item);
        $obj_text_content->updateTextContent($this->text_content, $this->text_content_id);
        // $this->text_content->save();
        
        return guarded_redirect('text-content', 'admin.text-content')->with(['message' => __('Updated Successfull'), 'status' => 'success']);

    }

    public function delete()
    {   
        $this->text_content->Status = DELETED_FLG;
        $obj_text_content = new TextContent();
        $obj_text_content->deleteTextContent(
            ['Status' => 3 ], $this->text_content_id);
        
        return guarded_redirect('text-content', 'admin.text-content')->with(['message' => __('Deleted Succesfull'), 'status' => 'success']);
    }
}