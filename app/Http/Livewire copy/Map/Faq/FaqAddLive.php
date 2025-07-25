<?php
namespace App\Http\Livewire\Map\Faq;

use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\Faq;
use App\Models\Map\FaqType;
use App\Models\ItemDescription;
use Livewire\Component;
use Livewire\WithFileUploads;

class FaqAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $Faq=['Status' => 2];
    public $item_title;
    public $item_description;
    public $faq_type;

    public function rules()
    {
        return [
           // Faq validation rules
           'Faq.FAQTypeId' => 'required|numeric',
           'Faq.TitleId' => 'required|numeric',
           'Faq.DescriptionId' => 'required|numeric',
           'Faq.Status' => 'required|numeric',
           'Faq.Rank' => '',

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
        $this->item_title = $obj_item_title->getItemsWithType(FAQ);

        $obj_item_description = new ItemDescription();
        $this->item_description = $obj_item_description->getAllItem();

        $obj_faq_type = new FaqType();
        $this->faq_type = $obj_faq_type->getAllFaqType();

        return view('livewire.map.faq.faq_add');
    }


    public function save()
    {
        $this->validate();
        // dd($this->Faq);
        DB::beginTransaction();

        try {
            // Create Faq
            $faq = Faq::create([
                'TitleId' => $this->Faq['TitleId'],
                'DescriptionId' => $this->Faq['DescriptionId'],
                'FAQTypeId' => $this->Faq['FAQTypeId'],
                'Status' => $this->Faq['Status'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,

            ]);

            DB::commit();

            return redirect()->route('faq')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


}
