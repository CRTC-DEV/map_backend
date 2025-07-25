<?php

namespace App\Http\Livewire\FrontEnd\Businesses;

use App\Models\Web\ConnectBusinesses;
use App\Models\Web\SubMenu;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class ConnectBusinessesDetail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 3;
    public $bid;
    // public $re_connect_bs;pu
    public $connect_businesses;
    public $originalText;
    public $submenu;
    public $item_title;

    public function mount($submenuid, $detailid)
    {
        $obj_submenu = new SubMenu();
        $this->submenu = $obj_submenu->getAllSubMenuById($submenuid);
        $this-> originalText = $this->submenu->title->textcontent->OriginalText ?? null;

        //$this->connect_businesses = ConnectBusinesses::findOrFail($detailid);
        $this->connect_businesses = ConnectBusinesses::where('SubMenuId', $submenuid)
            ->where('id', $detailid)
            ->firstOrFail();
        //tăng lượt xem        
        session()->forget('viewed_' . $detailid);
        if (!session()->has('viewed_' . $detailid)) {
            DB::table('ConnectBusinesses')->where('id', $detailid)->increment('View');
            session()->put('viewed_' . $detailid, true);
        }

        // Lấy các bài viết cùng chuyên mục (cùng loại, loại có thể là 'category_id' hoặc 'type')
        // $this->re_connect_bs = ConnectBusinesses::where('id', '!=', $id)
        //     //->where('category_id', $this->connect_businesses->category_id)
        //     ->orderBy('ModifiDate', 'desc')
        //     ->paginate(1); // Hiển thị 2 bài mỗi trang



        //dd($this->connect_businesses);
    }



    public function render()
    {
        //$this->incrementView();

        $re_connect_bs = ConnectBusinesses::where('id', '!=', $this->connect_businesses->id)
            ->where('Status', '!=', DISABLE)
            ->where('SubMenuId', $this->connect_businesses->SubMenuId)
       
            ->orderBy('ModifiDate', 'desc')
            ->paginate($this->perPage); // Hiển thị 2 bài mỗi trang

        //return view('livewire.frontend.businesses.connect_businesses_detail', compact('re_connect_bs'));
        return view('livewire.frontend.businesses.connect_businesses_detail', ['re_connect_bs' => $re_connect_bs]);


        //return view('livewire.frontend.businesses.connect_businesses_detail');
    }
}
