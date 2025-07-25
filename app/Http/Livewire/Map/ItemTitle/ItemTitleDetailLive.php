<?php

namespace App\Http\Livewire\Map\ItemTitle;

use App\Traits\LogsMapActivity;

use App\Models\ItemTitle;
use App\Models\TextContent;
use App\Models\Map\MapItem;
use Livewire\Component;

class ItemTitleDetailLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $item_title;
    public $item_title_id;
    public $textcontent;

    public function rules()
    {
        return [
            'item_title.TextContentId' => 'required|numeric',
            'item_title.Status' => 'required|numeric',
            'item_title.IsShow' => 'required|numeric',
            'item_title.Type' => 'required|numeric',


        ];
    }

    public function messages()
    {
        return [
            // 'item_title.CadId.required' => __('zzz'),
            // 'item_title.CadId.numeric' => __('zzz'),
        ];
    }

    public function mount($id)
    {
        $this->logMapPageView('Item Title Detail Page');

        $this->item_title_id = $id;
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemById($id);
        // dd( $this->item_title);
    }

    public function render()
    {
        $obj_text_content = new TextContent();
        $this->textcontent = $obj_text_content->getAllTextContent();
        return view('livewire.map.item-title.item_title_edit');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Item Title Detail');

        // dd($this->item_title);
        $this->validate();
        
        $obj_item_title = new ItemTitle();
        // $obj_item_title->insertMapItem($this->item_title);
        $obj_item_title->updateItem($this->item_title, $this->item_title_id);
        
        return guarded_redirect('item-title','admin.title')->with(['message' => __('Insert Successfull'), 'status' => 'success']);

    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Item Title Detail');
   
        if ($this->item_title) {
            $this->item_title->Status = DELETED_FLG;
            $obj_item_title = new ItemTitle();
            $obj_item_title->deleteItem($this->item_title_id);
            
            return guarded_redirect('item-title','admin.title')->with(['message' => __('Deleted Successfull'), 'status' => 'success']);
        } else {
            return guarded_redirect('item-title','admin.title')->with(['message' => __('Item not found'), 'status' => 'error']);
        }
    }
}
