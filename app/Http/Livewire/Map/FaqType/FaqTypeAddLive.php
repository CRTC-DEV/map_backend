<?php
namespace App\Http\Livewire\Map\FaqType;

use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\FaqType;
use Livewire\Component;
use Livewire\WithFileUploads;

class FaqTypeAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $FaqType=['Status' => 2];
    public $item_title;

    public function rules()
    {
        return [
           'FaqType.TitleId' => 'required|numeric',
           'FaqType.Status' => 'required|numeric',
           'FaqType.OrderIndex' => 'required|numeric',

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
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(FAQTYPE);


        return view('livewire.map.faq-type.faq_type_add');
    }


    public function save()
    {
        DB::beginTransaction();

        try {
            // Create FaqType
            $faq_type = FaqType::create([
                'TitleId' => $this->FaqType['TitleId'],
                'Status' => $this->FaqType['Status'],
                'OrderIndex' => $this->FaqType['OrderIndex'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),

            ]);

            DB::commit();

            return redirect()->route('faq-type')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


}
