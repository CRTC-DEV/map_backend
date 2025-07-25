<?php

namespace App\Http\Livewire\Map\TextContent;

use App\Traits\LogsMapActivity;

use App\Models\TextContent;
use Livewire\Component;

class TextContentListLive extends Component
{
    
    use LogsMapActivity;
public $text_content;
    public function mount(){
        $this->logMapPageView('Text Content List Page');

        // $obj_item = new ItemTitle();
        $obj_text_content= new TextContent();
        $this->text_content = $obj_text_content->getAllTextContent();
        // dd($this->map_item);
    }
    public function render()
    {   
        return view('livewire.map.text-content.text_content_list');
    }
}
