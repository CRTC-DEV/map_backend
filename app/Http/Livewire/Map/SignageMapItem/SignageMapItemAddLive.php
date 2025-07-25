<?php

namespace App\Http\Livewire\Map\SignageMapItem;

use Illuminate\Support\Facades\DB;
use App\Models\Map\SignageMapItem;
use App\Models\Map\MapItem;
use App\Models\ItemTitle;
use App\Models\Map\Signages;
use App\Models\Map\T2Location;
use Livewire\Component;
use Livewire\WithFileUploads;

class SignageMapItemAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $SignageMapItem = ['Status' => 2];
    public $Signage;
    public $MapItem;
    public $selectedSignages = []; // Các Signages được chọn
    public $selectedMapItems = []; // Các MapItems được chọn


    public function rules()
    {
        $rules = [];

        // Quy tắc luôn áp dụng cho SignageMapItem
        $rules = array_merge($rules, [
            'SignageMapItem.Status' => 'required|numeric',
            // 'SignageMapItem.orderIndex' => 'required|integer',
            'SignageMapItem.SignageId'=> 'required|integer',
            'SignageMapItem.MapItemId'=> 'required|integer',
        ]);

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
        
    }

    public function render()
    {
        $obj_map_item = new MapItem();
        $this->MapItem = $obj_map_item->getAllMapItems();

        $obj_Signage = new Signages();
        $this->Signage = $obj_Signage->getAllSignages();
        // dd($this->MapItem);
        return view('livewire.map.signage-mapitem.signage_mapitem_add');
    }


    public function save()
    {

        $this->validate();
        DB::beginTransaction();

        try {
            
            // Link Signage and MapItem
            // dd($signageId , $deviceId,$this->isSignageDisabled,$signage);
            
            SignageMapItem::create([
                'SignageId' => $this->SignageMapItem['SignageId'],
                'MapItemId' => $this->SignageMapItem['MapItemId'],
                'Status' => $this->SignageMapItem['Status'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
            ]);
           

            DB::commit();

            return redirect()->route('signage-mapitem')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
    public function opensavelist()
    {
        $this->emit('openListMapItemSignage');
    }

    public function insertlist()
    {
        if (empty($this->selectedSignages) || empty($this->selectedMapItems)) {
            session()->flash('message', 'Please select at least one Signage and one MapItem.');
            session()->flash('status', 'warning');
            return;
        }

        DB::beginTransaction();

        try {
            $skippedEntries = []; // Store list of skipped pairs

            // Iterate through all combinations of SignageId and MapItemId
            foreach ($this->selectedSignages as $signageId) {
                foreach ($this->selectedMapItems as $mapItemId) {
                    // Check if this pair already exists
                    $exists = SignageMapItem::where('SignageId', $signageId)
                        ->where('MapItemId', $mapItemId)
                        ->exists();

                    if ($exists) {
                        // Add to skipped list
                        $skippedEntries[] = "SignageId: $signageId, MapItemId: $mapItemId";
                        continue; // Skip if exists
                    }

                    // Create new if doesn't exist
                    SignageMapItem::create([
                        'SignageId' => $signageId,
                        'MapItemId' => $mapItemId,
                        'Status' => $this->SignageMapItem['Status'],
                        'CreatedDate' => now(),
                        'ModifiDate' => now(),
                        'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                    ]);
                }
            }

            DB::commit();

            // Handle notifications
            if (!empty($skippedEntries)) {
                session()->flash(
                    'message',
                    'Insert Successful with some duplicates skipped: ' . implode('; ', $skippedEntries)
                );
                session()->flash('status', 'warning');
            } else {
                session()->flash('message', __('Insert Successful'));
                session()->flash('status', 'success');
            }

            return redirect()->route('signage-mapitem');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
