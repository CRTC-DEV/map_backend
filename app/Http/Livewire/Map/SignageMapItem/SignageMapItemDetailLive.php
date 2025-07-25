<?php

namespace App\Http\Livewire\Map\SignageMapItem;

use App\Models\Map\SignageMapItem;
use App\Models\Map\DeviceTouchScreen;
use App\Models\Map\Signages;
use App\Models\ItemTitle;
use App\Models\Map\MapItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;

class SignageMapItemDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $signage_id;
    public $SignageMapItem ;
    public $mapitem_id;
    public $Signage;
    public $MapItem;

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

    public function mount($id)
    {
        [$this->signage_id, $this->mapitem_id] = explode(",", $id);

        $this->SignageMapItem = SignageMapItem::where('SignageId', $this->signage_id)
            ->where('MapItemId', $this->mapitem_id)
            ->firstOrFail()
            ->toArray();
        
        $this->Signage = Signages::findOrFail($this->signage_id)->toArray();
        $this->MapItem = MapItem::findOrFail($this->mapitem_id)->toArray();
    }

    public function render()
    {
        $obj_map_item = new MapItem();
        $this->MapItem = $obj_map_item->getAllMapItems();

        $obj_Signage = new Signages();
        $this->Signage = $obj_Signage->getAllSignages();

        return view('livewire.map.signage-mapitem.signage_mapitem_edit');
    }

    public function save()
    {
        $this->validate();
       
        DB::beginTransaction();

        try {

            $signageMapItem = SignageMapItem::where('SignageId', $this->signage_id)
                ->where('MapItemId', $this->mapitem_id);

            $signageMapItem->update([
                'SignageId' => $this->SignageMapItem['SignageId'],
                'MapItemId' => $this->SignageMapItem['MapItemId'],
                'Status' => $this->SignageMapItem['Status'],
                'ModifiDate' => now(),
            ]);

            DB::commit();

            return redirect()->route('signage-mapitem')->with(['message' => __('Update Successful'), 'status' => 'success']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            SignageMapItem::where('SignageId', $this->signage_id)
                ->where('MapItemId', $this->mapitem_id)
                ->delete();

            DB::commit();

            return redirect()->route('signage-mapitem')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}