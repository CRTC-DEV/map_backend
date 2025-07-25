<?php

namespace App\Http\Livewire\FrontEnd\Businesses;

use App\Models\Web\SubMenu;
use App\Models\Web\ConnectBusinesses;
use Livewire\Component;
use Livewire\WithPagination;

class ConnectBusinessesView extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $submenu;
    public $connect_businesses;
    public $originalText;
    public $submenu_id;
    public $perPage = 3;


    public function mount($submenuid)
    {
        //dd($submenuid);
        $obj_submenu = new SubMenu();
        $this->submenu = $obj_submenu->getAllSubMenuById($submenuid);

        if (!$this->submenu) {
            abort(404);
            // Handle case where submenu is not found
            //throw new \Exception("Submenu not found for ID: " . $submenuid);
        }

        // Access textcontent through the title relationship
        $this->submenu_id = $submenuid;
        $this->originalText = $this->submenu->title->textcontent->OriginalText ?? null;
        //dd($this->originalText); 
        $this->connect_businesses = ConnectBusinesses::where('SubMenuId', $submenuid)->first();

        if (!$this->connect_businesses) {
            // Handle the case where no business is found for this SubMenuId
            // For example, you could redirect to an error page or set a default value
            // This is just an example, adjust as needed:
            $this->connect_businesses = new ConnectBusinesses();
            $this->connect_businesses->SubMenuId = $submenuid;
        }
    }


    public function render()
    {
        $query = ConnectBusinesses::where('SubMenuId', $this->connect_businesses->SubMenuId)
            ->where('Status', '!=', DISABLE);

        if ($this->connect_businesses->Id) {
            $query->where('Id', '!=', $this->connect_businesses->Id)
                ->where('Status', '!=', DISABLE)
                ->orderBy('ModifiDate', 'DESC');
        }

        $allBids = $query
            ->orderBy('ModifiDate', 'DESC')
            ->get();

        // Convert the collection to a paginator
        $bids = new \Illuminate\Pagination\LengthAwarePaginator(
            $allBids->forPage($this->page, $this->perPage),
            $allBids->count(),
            $this->perPage,
            $this->page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('livewire.frontend.businesses.connect_businesses_view', [
            'bids' => $bids,
        ]);
    }
}
