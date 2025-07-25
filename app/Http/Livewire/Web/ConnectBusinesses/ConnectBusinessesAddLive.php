<?php

namespace App\Http\Livewire\Web\ConnectBusinesses;

use Illuminate\Support\Facades\DB;
use App\Models\Web\ConnectBusinesses;
use App\Models\Web\SubMenu;
use App\Models\Web\TopMenu;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use App\Services\EmailService;

class ConnectBusinessesAddLive extends Component
{
    use WithFileUploads;
    // protected $listeners = ['updateEditorContent'];
    public $message;
    public $ConnectBusinesses = [
        'Status' => 2,
        'Title' => '',
        'Description' => '',
    ];
    public $available_submenu;
    public $ImagePath;
    public $File;
    public $editor;

    public function rules()
    {
        $rules = [];

        // Quy tắc luôn áp dụng cho ConnectBusinesses
        $rules = array_merge($rules, [
            'ConnectBusinesses.Title' => 'required',
            'ConnectBusinesses.Description' => '',
            'ConnectBusinesses.Status' => 'required|numeric',
            // 'ConnectBusinesses.Banner' => '',
            // 'ConnectBusinesses.File' => '',
            'File' => 'max:20480',
            'ConnectBusinesses.SubMenuId' => 'required|numeric',
            'ImagePath.*' => 'image|max:2048',
        ]);

        return $rules;
    }

    public function updateEditorContent($content)
    {
        $this->ConnectBusinesses['Description'] = $content;
        // dd($this->ConnectBusinesses);
    }


    public function messages()
    {
        return [];
    }

    public function mount()
    {
        $this->available_submenu = (new SubMenu())->getAllSubMenu();
    }

    public function render()
    {
        return view('livewire.web.connect-businesses.connect_businesses_add');
    }


    public function save()
    {
        $this->ConnectBusinesses['Description'] = $this->editor;
        // dd($this->editor,$this->ConnectBusinesses['Description']);

        $this->validate();
        DB::beginTransaction();
        $this->ConnectBusinesses['Banner'] = $this->ImagePath ? uploadImage($this->ImagePath, 'banners') : null;
        $this->ConnectBusinesses['File'] = $this->File ? $this->File->store('pdfs', 'public') : null;

        try {
            $business = ConnectBusinesses::create([
                'Title' => $this->ConnectBusinesses['Title'],
                'Description' => $this->ConnectBusinesses['Description'] ?: null,
                'Status' => $this->ConnectBusinesses['Status'],
                'Banner' => $this->ConnectBusinesses['Banner'] ?: null,
                'File' => $this->ConnectBusinesses['File'] ?: null,
                'SubMenuId' => $this->ConnectBusinesses['SubMenuId'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->id : (auth()->guard('user')->check() ? auth()->guard('user')->user()->id : null),
            ]);
            File::cleanDirectory(public_path('storage/livewire-tmp'));

            // connect_businesses_log(print_r($this->ConnectBusinesses . auth()->guard('admin')->user(), true));
            connect_businesses_log(json_encode([
                'ID' => $business->id, // Lấy ID từ model trả về
                'Title' => $business->Title,
                'UserID' => auth()->guard('admin')->user()->id ?? null,
                'UserEmail' => auth()->guard('admin')->user()->email ?? null,
                'Type'  => 'Created'
            ], JSON_PRETTY_PRINT));

            // Send email notification
            $emailService = app(EmailService::class);
            $user = auth()->guard('admin')->check() ? auth()->guard('admin')->user() : auth()->guard('user')->user();
            
            $emailData = [
                'title' => 'New Business Connection Post Created',
                'action' => 'Created',
                'businessTitle' => $business->Title,
                // 'description' => $business->Description,
                // 'banner' => $business->Banner,
                // 'file' => $business->File,
                'modifiedBy' => $user->name ?? 'System',
                'date' => now()->format('Y-m-d H:i:s')
            ];

            // Send to admin
            $emailService->sendHtmlEmail(
                config('mail.from.address'),
                'New Business Connection Post Created',
                'emails.connect-businesses-notification',
                $emailData
            );

            // Send to the user who created the post
            if ($user->email) {
                $emailService->sendHtmlEmail(
                    $user->email,
                    'Your Business Connection Post Has Been Created',
                    'emails.connect-businesses-notification',
                    $emailData
                );
            }

            DB::commit();

            return redirect()->route('admin.connect.business')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
