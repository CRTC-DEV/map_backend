<?php
namespace App\Http\Livewire\Map\Signage;

use App\Traits\LogsMapActivity;

use App\Models\Map\ItemType;
use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\Signages;
use Livewire\Component;
use Livewire\WithFileUploads;

class SignageAddLive extends Component
{
    use WithFileUploads, LogsMapActivity;
    public $message;
    public $Signage=['Status' => 2];
    public $Screen;
    public $item_title;
    public $location;
    public $item_type;

    public function rules()
    {
        return [
            
           // Signage validation rules
           'Signage.cadId' => 'required|string|max:255',
           'Signage.titleId' => 'required|numeric',
           'Signage.longitudes' => 'required|numeric',
           'Signage.latitudes' => 'required|numeric',
           'Signage.Status' => 'required|numeric',
           'Signage.Description' => '',
           'Signage.IconUrl' => '',
           'Signage.MapUrl' => '',
           'Signage.BackgroundUrl' => '',

        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Signage Add Page');


    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(SIGNAGE);//1 Signage
        //dd($this->item_title);

        $obj_item_type = new ItemType();
        $this->item_type = $obj_item_type->getAllItemTypes();


        return view('livewire.map.signage.signage_add');
    }


    public function save()
    {
        $this->logMapAttempt('SAVE', 'Signage Add');

        $this->validate();
        DB::beginTransaction();

        try {
            // Create Signage
            $signage = Signages::create([
                'CadId' => $this->Signage['cadId'],
                'TitleId' => $this->Signage['titleId'],
                'Longitudes' => $this->Signage['longitudes'],
                'Latitudes' => $this->Signage['latitudes'],
                'Description' => $this->Signage['Description'],
                'IconUrl' => $this->Signage['IconUrl'],
                'MapUrl' => $this->Signage['MapUrl'],
                'BackgroundUrl' => $this->Signage['BackgroundUrl'],
                'Status' => $this->Signage['Status'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,
            ]);

            DB::commit();

            return redirect()->route('signage')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

}
