<?php

namespace App\Http\Livewire\Web\ConnectBusinesses;

use Illuminate\Support\Facades\DB;
use App\Models\Web\ConnectBusinesses;
use App\Models\Web\SubMenu;
use App\Models\Web\TopMenu;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConnectBusinessesAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $ConnectBusinesses = ['Status' => 2];
    public $available_submenu;
    public $ImagePath;
    public $File;

    public function rules()
    {
        $rules = [];

        // Quy tắc luôn áp dụng cho ConnectBusinesses
        $rules = array_merge($rules, [
            'ConnectBusinesses.Title'=> 'required',
            'ConnectBusinesses.Description'=> '',
            'ConnectBusinesses.Status' => 'required|numeric',
            // 'ConnectBusinesses.Banner' => '',
            // 'ConnectBusinesses.File' => '',
            'File' => 'max:5120',
            'ConnectBusinesses.SubMenuId' => 'required|numeric',
            'ImagePath.*' => 'image|max:2048',
        ]);

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
        $this->available_submenu = (new SubMenu())->getAllSubMenu();
        // dd($this->available_submenu);
    }

    public function render()
    {
        return view('livewire.web.connect-businesses.connect_businesses_add');
    }


    public function save()
    {
        // dd($this->ConnectBusinesses);
        $this->validate();
        DB::beginTransaction();
        //dd($this->ConnectBusinesses['Banner']);
        $this->ConnectBusinesses['Banner'] = $this->ImagePath ? uploadImage($this->ImagePath, 'banners') : null;
        $this->ConnectBusinesses['File'] = $this->File ? $this->File->store('pdfs', 'public') : null;
        
        try {
            ConnectBusinesses::create([
                'Title' => $this->ConnectBusinesses['Title'],
                'Description' => $this->ConnectBusinesses['Description'],
                'Status' => $this->ConnectBusinesses['Status'],
                'Banner' => $this->ConnectBusinesses['Banner'],
                'File' => $this->ConnectBusinesses['File'],
                'SubMenuId' => $this->ConnectBusinesses['SubMenuId'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
            ]);
            DB::commit();

            return redirect()->route('admin.connect.business')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
