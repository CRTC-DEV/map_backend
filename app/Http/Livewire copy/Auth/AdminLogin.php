<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
// use App\Models\Admin as User;
use App\Models\Admin;

class AdminLogin extends Component
{
    public $email;
    public $password;
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        if (auth()->guard('admin')->user()) {
            return redirect()->intended('/admin-dashboard');
        }

    }

    public function login()
    {

        $this->validate();
        $obj_admin = new Admin();
        $admin = $obj_admin->getAdminByEmail($this->email);
        // dd($this->email, $this->password);
        if (auth()->guard('admin')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            auth()->guard('admin')->login($admin,$this->remember_me);
            // Nếu đăng nhập thành công, chuyển hướng đến trang dashboard
            return redirect()->intended('/admin-dashboard');
        }else{
            return $this->addError('password', trans('auth.password'));
        }
        
    }
    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->intended(route('admin.login'));
    }
    public function render()
    {
        // dd(in_array(request()->route()->getName()));
        return view('livewire.auth.admin_login');
    }
}
