<?php
namespace App\Http\Livewire\Map\BannerAdv;

use App\Models\Map\BannerAdv;
use App\Models\ItemDescription;
use App\Models\ItemTitle;
use App\Models\Map\T2Location;
use Livewire\Component;
use Livewire\WithFileUploads;

class BannerAdvAddLive extends Component
{
    use WithFileUploads;
    protected $listeners = ['setMediaType'];
    public $message;
    public $banner_adv = ['Status' => 2];
    public $item_title;
    public $t2_location;
    public $description;
    public $ImagePaths = [];
    public $IsVideo = TYPE_IMAGE;

    public function rules()
    {
        return [
            
            'banner_adv.T2LocationId' => 'required|numeric', 
            'banner_adv.TitleId' => 'required|numeric', 
            'banner_adv.DescriptionId'=> 'required|numeric', 
            // 'banner_adv.UserId', 
            'banner_adv.Status'=> 'required|numeric', 
            'banner_adv.StartDate'=> 'required', 
            'banner_adv.ExpiryDate'=> 'required|after:banner_adv.StartDate', 
            'banner_adv.VideoURL'=> '', 
            'banner_adv.IsVideo'=> '', 
            // 'ImagePathName1' => '', 
            // 'ImagePathName2' => '', 
            // 'ImagePathName3' => '', 
            'banner_adv.LinkURL'  => 'required|string',
            // 'IsVideo' => '',
            'ImagePaths.*' => 'image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function mount()
    {
        // $this->banner_adv['banner_adv.IsVideo'] = $this->IsVideo;
        //use only for load page, not refresh data
        //$this->item_title = ItemTitle::where('Status', '!=', DELETED_FLG)->get();
    }

    public function render()
    {
        //for refresh data
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getAllItems();

        $obj_description = new ItemDescription();
        $this->description = $obj_description->getAllItem();

        $obj_item_title = new T2Location();
        $this->t2_location = $obj_item_title->getAllT2Location();
       
        return view('livewire.map.banner-adv.banner_adv_add');
    }

    public function save(){
        // dd($this->banner_adv,$this->IsVideo);
        $this->validate();
        $this->banner_adv['IsVideo'] = $this->IsVideo;
        $uploadedPaths = [];
        if ($this->ImagePaths) {
            foreach ($this->ImagePaths as $image) {
                $uploadedPaths[] = $this->uploadImage($image);
            }
        }

        $this->banner_adv['ImagePaths'] = json_encode($uploadedPaths);
        // dd($this->banner_adv);
        
        $obj_banner_adv = new BannerAdv();
        $obj_banner_adv->insertBannerAdv($this->banner_adv);

        return redirect()->route('banner-adv')->with(['message' => __('Insert completed'), 'status' => 'success']);

    }

    public function uploadImage($image)
    {
        return uploadMultipleImages([$image], 'img_banner')[0];
    }

    public function setMediaType($type)
    {
        $this->IsVideo = $type;
    }
}
