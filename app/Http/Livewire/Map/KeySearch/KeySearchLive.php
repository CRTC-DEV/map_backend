<?php

namespace App\Http\Livewire\Map\KeySearch;

use App\Traits\LogsMapActivity;
use App\Models\Map\KeySearch;
use App\Exports\KeySearchExport;
use Livewire\Component;
use App\Models\ItemTitle;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class KeySearchLive extends Component
{
    use LogsMapActivity;
    
    public $key_kearch;

    public function mount(){
        $this->logMapPageView('Key Search Page');

        // $obj_item = new ItemDescription();
        $obj_key_search = new KeySearch();
        $this->key_kearch = $obj_key_search->getAllItems();
        // dd($this->item_type);
    }

    public function exportExcel()
    {
        // Log export action
        $this->logMapComponentAction('export', 'Key Search', null, [
            'total_records' => count($this->key_kearch),
            'export_format' => 'excel'
        ]);
        
        $filename = 'key_search_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new KeySearchExport(), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }
    
    public function render()
    {
        return view('livewire.map.key-search.key_search_list');
    }
}
