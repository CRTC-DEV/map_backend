<?php

namespace App\Http\Livewire\Web\Admin;

use App\Models\Admin;
use App\Models\User;
use App\Models\Menu;
use Livewire\Component;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WebAdminManagementAdd extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $admin = [
        'name' => null,
        'email' => null,
        'password_text' => null,
        'role_id' => 3
    ];
    public function rules()
    {
        return [
            'admin.name' => 'required',
            'admin.email' => ['required', 'string', 'email', 'unique:admin,email', 'max:255'],
            'admin.password_text' => 'required',
            'admin.role_id' => '',
        ];
    }

    public function messages()
    {
        return [
           
        ];
    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.web.admin.admin_add');
    }

    public function save()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            // Create the admin account
            $obj_admin = new Admin();
            $admin = $obj_admin->insertAdmin($this->admin);
            
            // Send email notification with credentials
            $emailService = app(EmailService::class);
            
            $emailData = [
                'name' => $this->admin['name'],
                'email' => $this->admin['email'],
                'password' => $this->admin['password_text']
            ];
            
            // Send email to the newly created admin
            $emailService->sendHtmlEmail(
                $this->admin['email'],
                'Your Admin Account Has Been Created',
                'emails.admin-account-created',
                $emailData
            );
            
            // Send notification to the admin who created this account
            $currentAdmin = auth()->guard('admin')->user();
            if ($currentAdmin && $currentAdmin->email) {
                $emailService->sendHtmlEmail(
                    $currentAdmin->email,
                    'New Admin Account Created',
                    'emails.admin-account-created',
                    $emailData
                );
            }
            
            DB::commit();
            
            return redirect()->route('admin.web')->with(['message' => __('Insert completed'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
