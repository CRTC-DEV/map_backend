<?php

namespace App\Http\Livewire\Map\BannerAdv;

use App\Models\Map\BannerAdv;
use Livewire\Component;
use App\Models\ItemTitle;

class BannerAdvLive extends Component
{
    public $item_type;
    public $banner_adv;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_banner_advs= new BannerAdv();
        $this->banner_adv = $obj_banner_advs->getAllBannerAdv();
        // $obj_item_title = new ItemTitle();
        // $this->item_title = $obj_item_title->getAllItems();
        // dd($this->item_type);
    }
    public function render()
    {
        return view('livewire.map.banner-adv.banner_adv');
    }
}
