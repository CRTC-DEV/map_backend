<?php

namespace App\Http\Livewire\Web;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminInformation extends Component
{
    public $admin_email;
    public $admin;
    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    public function rules()
    {
        return [
            'admin.email' => '',
            'admin.name' => '',
            'old_password' => 'required',
            'new_password' => 'required|min:6|same:new_password_confirmation',
            'new_password_confirmation' => 'required|min:6',
        ];
    }
    public function messages(){
        return [
            'old_password.required' => 'The old password field is required.',
            'new_password.required' => 'The new password field is required.',
            'new_password.min' => 'The new password must be at least 6 characters.',
            'new_password.same' => 'The new password and new password confirmation must match.',
            'new_password_confirmation.required' => 'The new password confirmation field is required.',
            'new_password_confirmation.min' => 'The new password confirmation must be at least 6 characters.',
        ];
    }

    public function mount()
    {
        $this->admin = auth()->guard('admin')->user();
        // dd($this->admin);
        $this->admin_email = auth()->guard('admin')->user()->email;
        // $this->admin = Admin::where('email', $this->admin_email)->first();
    }

    public function render()
    {
        return view('livewire.web.admin_information');
    }

    public function addChangePasswordModal()
    {
        // dd(1);
        $this->resetValidation(); // Reset lỗi cũ khi mở modal
        $this->reset(['old_password', 'new_password', 'new_password_confirmation']); // Xóa dữ liệu cũ
        $this->emit('openChangePasswordModal');
    }

    public function savePasswordChanged()
    {
        // dd($this->old_password);
        $this->validate();
        
        if (!Hash::check($this->old_password, $this->admin->password)) {
            $this->addError('old_password', 'The old password is incorrect.');
            session()->flash('message', 'The old password is incorrect.');
        }else{
            // dd($this->admin['password_text'],$this->new_password);
            $this->admin['password'] = Hash::make($this->new_password);
            $this->admin['password_text'] = $this->new_password;
            
            // dd($this->admin, $this->old_password, $this->new_password, Hash::make($this->new_password));
            $obj_admin  = new Admin();
            $obj_admin->updateAdmin($this->admin,$this->admin->id);
    
            return redirect()->route('admin.profile')->with(['message' => __('Update completed'), 'status' => 'success']);
        }
    }
}