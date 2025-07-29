<?php

namespace App\Exports;

use App\Models\Map\KeySearch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KeySearchExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        $keySearch = new KeySearch();
        $data = $keySearch->getAllItems();
        
        // Transform data for export
        return collect($data)->map(function ($item) {
            return [
                $item->Id,
                $item->InputSearch,
                $item->DirectLink,
                $item->DeviceCode,
                $item->CreatedDate ? \Carbon\Carbon::parse($item->CreatedDate)->format('Y-m-d H:i:s') : '',
                $item->ModifiDate ? \Carbon\Carbon::parse($item->ModifiDate)->format('Y-m-d H:i:s') : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Input Search',
            'Direct Link', 
            'Device Code',
            'Created Date',
            'Modified Date'
        ];
    }
}
