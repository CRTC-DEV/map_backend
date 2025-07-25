<?php

namespace App\Http\Livewire\Web\Admin;

use App\Models\Admin;
use App\Models\Menu;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WebAdminManagementDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $admin;
    public function rules()
    {
        return [
            'admin.name' => 'required',
            'admin.email' => ['required', 'string', 'email', 'max:255', 
                Rule::unique('admin', 'email')->ignore($this->admin['id']),
            ],
            'admin.password_text' => 'required',
            'admin.role_id' => '',
        ];
    }

    public function messages()
    {
        return [
           
        ];
    }

    public function mount($id)
    {
        $this->admin = Admin::find($id);
    }

    public function render()
    {
        return view('livewire.web.admin.admin_edit');
    }

    public function save()
    {
        $this->validate();
        // dd($this->admin);
        $obj_admin  = new Admin();
        $obj_admin->updateAdmin($this->admin,$this->admin->id);

        return redirect()->route('admin.web')->with(['message' => __('Update completed'), 'status' => 'success']);
    }

}
