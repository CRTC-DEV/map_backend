<?php

namespace App\Http\Livewire\Map\AdminManagement;

use App\Traits\LogsMapActivity;

use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminManagementAdd extends Component
{
    use WithPagination, LogsMapActivity;
    use WithFileUploads;

    public $user = [
        'name' => null,
        'email' => null,
        'password_text' => null,
        'role_id' => 3
    ];
    public $role;
    public function rules()
    {
        return [
            'user.name' => 'required',
            'user.email' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
            'user.password_text' => 'required',
            'user.role_id' => '',
        ];
    }

    public function messages()
    {
        return [
           
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Admin Management Add Page');

        $this->role = Role::all();
    }

    public function render()
    {
        return view('livewire.map.admin-management.admin_management_add');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Admin Management');

        $this->validate();
        // dd($this->user);
        $obj_user  = new User();
        $obj_user->insertUser($this->user);

        return redirect()->route('admin-management')->with(['message' => __('Insert completed'), 'status' => 'success']);
    }

}
