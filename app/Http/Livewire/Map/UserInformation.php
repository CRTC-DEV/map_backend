<?php

namespace App\Http\Livewire\Map;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserInformation extends Component
{
    public $user_email;
    public $user;
    public $old_password;
    public $new_password;
    public $new_password_confirmation;
    public $updateMode = false;

    protected $rules = [
        'user.name' => 'required|string|max:255'
    ];

    protected $validationAttributes = [
        'user.name' => 'full name'
    ];

    public function passwordRules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:6|same:new_password_confirmation',
            'new_password_confirmation' => 'required|min:6',
        ];
    }
    
    public function messages(){
        return [
            'user.name.required' => 'The full name field is required.',
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
        $this->user = auth()->guard('user')->user();
        $this->user_email = $this->user->email;
    }

    public function render()
    {
        return view('livewire.map.user_information');
    }

    public function enableEdit()
    {
        $this->updateMode = true;
    }

    public function cancelEdit()
    {
        $this->updateMode = false;
        $this->user = auth()->user();
        $this->resetValidation();
    }

    public function saveProfileInformation()
    {
        $this->validate();
        
        $userData = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password_text' => $this->user->password_text,
            'role_id' => $this->user->role_id
        ];
        
        $obj_user = new User();
        $obj_user->updateUser($userData, $this->user->id);
        
        $this->updateMode = false;
        return redirect()->route('user.profile')->with(['message' => __('Profile information updated successfully'), 'status' => 'success']);
    }

    public function addChangePasswordModal()
    {
        $this->resetValidation(); 
        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);
        $this->emit('openChangePasswordModal');
    }

    public function savePasswordChanged()
    {
        $this->validate($this->passwordRules());
        
        if (!Hash::check($this->old_password, $this->user->password)) {
            $this->addError('old_password', 'The old password is incorrect.');
            session()->flash('message', 'The old password is incorrect.');
            return;
        }
        
        $userData = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password_text' => $this->new_password,
            'role_id' => $this->user->role_id
        ];
        
        $obj_user = new User();
        $obj_user->updateUser($userData, $this->user->id);

        $this->emit('closeChangePasswordModal');
        return redirect()->route('user.profile')->with(['message' => __('Password changed successfully'), 'status' => 'success']);
    }
}
