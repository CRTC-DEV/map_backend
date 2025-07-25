<?php

namespace App\Http\Livewire\Map\ItemTitle;

use App\Models\ItemTitle;
use App\Models\Map\MapItem;
use App\Models\TextContent;
use Livewire\Component;

class ItemTitleAddLive extends Component
{

    public $message;
    public $item_title = ['Status' => 2,'IsShow'=>1];   
    public $textcontent;

    public function rules()
    {
        return [
            'item_title.TextContentId' => 'required|numeric',
            'item_title.Status' => 'required|numeric',
            'item_title.Type' => 'required|numeric',
            
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
        $obj_text_content = new TextContent();
        $this->textcontent = $obj_text_content->getAllTextContent();
        
        return view('livewire.map.item-title.item_title_add');
    }

    public function save(){
        
        $this->validate();
        //dd($this->item_title);
        $obj_item_title = new ItemTitle();
        $obj_item_title->insertItem($this->item_title);
        
        return guarded_redirect('item-title','admin.title')->with(['message' => __('Insert Succesful'), 'status' => 'success']);

    }
}
