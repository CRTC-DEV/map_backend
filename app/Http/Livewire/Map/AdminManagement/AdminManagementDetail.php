<?php

namespace App\Http\Livewire\Map\AdminManagement;

use App\Traits\LogsMapActivity;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminManagementDetail extends Component
{
    use WithPagination, LogsMapActivity;
    use WithFileUploads;

    public $user;
    public $role;

    public function rules()
    {
        return [
            'user.name' => 'required',
            'user.email' => ['required', 'string', 'email', 'max:255', 
                Rule::unique('users', 'email')->ignore($this->user['id']),
            ],
            'user.password_text' => 'required',
            'user.role_id' => '',
        ];
    }

    public function messages()
    {
        return [
           
        ];
    }

    public function mount($id)
    {
        $this->logMapPageView('Admin Management Detail Page');

        $this->user = User::find($id);
         $this->role = Role::all();
    }

    public function render()
    {
        return view('livewire.map.admin-management.admin_management_edit');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Admin Management');

        $this->validate();
        // dd($this->user);
        $obj_user  = new User();
        $obj_user->updateUser($this->user,$this->user->id);

        return redirect()->route('admin-management')->with(['message' => __('Update completed'), 'status' => 'success']);
    }

}
