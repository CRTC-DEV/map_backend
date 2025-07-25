<?php

namespace App\Http\Livewire\Map\ItemDescription;

use App\Traits\LogsMapActivity;

use App\Models\ItemDescription;
use App\Models\Map\RouteMapItem;
use App\Models\TextContent;
use Livewire\Component;

class ItemDescriptionAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $item_description = ['Status' => 2];   
    public $text_content;

    public function rules()
    {
        return [
            'item_description.TextContentId' => 'required|numeric',
            'item_description.Status' => 'required|numeric',

        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Item Description Add Page');


    }

    public function render()
    {
        $obj_text_content = new TextContent();
        $this->text_content = $obj_text_content->getAllTextContent(); 
 
        return view('livewire.map.item-description.item_description_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Item Description Add');

        
        $this->validate();
        //dd($this->item_description);
        $obj_item_description = new ItemDescription();
        $obj_item_description->insertItem($this->item_description);
        
        return guarded_redirect('item-description','admin.description')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }
}
