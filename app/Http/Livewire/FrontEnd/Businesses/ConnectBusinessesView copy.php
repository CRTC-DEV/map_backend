<?php
namespace App\Http\Livewire\FrontEnd\Businesses;

use App\Models\Web\ConnectBusinesses;
use Livewire\Component;
use Livewire\WithPagination;

class ConnectBusinessesView extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 3;

    public function render()
    {
        $obj_connect_businesses = new ConnectBusinesses();
        $allBids = $obj_connect_businesses->getAllConnetBussinesses();
        
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