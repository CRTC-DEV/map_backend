<?php

namespace App\Http\Livewire\Map\ItemType;

use App\Traits\LogsMapActivity;

use App\Models\ItemTitle;
use App\Models\Map\ItemType;
use Livewire\Component;

class ItemTypeAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $item_type = ['Status' => 2,'IsShow' =>1];

    public function rules()
    {
        return [
           
            'item_type.Name' => 'required|string',
            'item_type.Description' => 'required|string',
            'item_type.Status' => 'required|numeric',
            'item_type.IsShow' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            // 'item_type.CadId.required' => __('zzz'),
            // 'item_type.CadId.numeric' => __('zzz'),
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Item Type Add Page');


    }

    public function render()
    {
       
        return view('livewire.map.item-type.item_type_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Item Type Add');

        
        $this->validate();

        $obj_item_type = new ItemType();
        $obj_item_type->insertItemType($this->item_type);

        return redirect()->route('item-type')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }
}
