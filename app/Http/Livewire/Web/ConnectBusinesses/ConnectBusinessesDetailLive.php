<?php

namespace App\Http\Livewire\Web\ConnectBusinesses;

use App\Models\Web\ConnectBusinesses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Web\SubMenu;
use App\Models\Web\TopMenu;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;
use App\Services\EmailService;

class ConnectBusinessesDetailLive extends Component
{
    use WithFileUploads;
    // protected $listeners = ['updateEditorContent'];
    public $message;
    public $ConnectBusinesses = ['Description' => '',];
    public $available_submenu;
    public $ImagePath;
    public $File;
    public $ConnectBusinesses_Id;
    public $editor;

    public function rules()
    {
        return [
            'ConnectBusinesses.Title' => 'required',
            'ConnectBusinesses.Description' => '',
            'ConnectBusinesses.Status' => 'required|numeric',
            'ConnectBusinesses.Banner' => '',
            'ConnectBusinesses.File' => '',
            'ConnectBusinesses.SubMenuId' => 'required|numeric',
            'File' => 'max:20480',
            'ImagePath.*' => 'image|max:2048',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        $this->ConnectBusinesses_Id = $id;
        $this->ConnectBusinesses = ConnectBusinesses::find($id)->toArray();
        $this->File = $this->ConnectBusinesses['File'];
        $this->ImagePath = $this->ConnectBusinesses['Banner'];
        $this->available_submenu = (new SubMenu())->getAllSubMenu();
        $this->editor = $this->ConnectBusinesses['Description'];
    }

    public function render()
    {
        return view('livewire.web.connect-businesses.connect_businesses_edit');
    }

    public function save()
    {
        $this->ConnectBusinesses['Description'] = $this->editor;

        $this->validate();
        DB::beginTransaction();
       
        try {
            // Handle image upload
            if ($this->ImagePath instanceof \Illuminate\Http\UploadedFile) {
                // Delete old image if exists
                if (!empty($this->ConnectBusinesses['Banner'])) {
                    if (Storage::disk('public')->exists($this->ConnectBusinesses['Banner'])) {
                        Storage::disk('public')->delete($this->ConnectBusinesses['Banner']);
                    }
                }
                // Upload new image
                $this->ConnectBusinesses['Banner'] = uploadImage($this->ImagePath, 'banners');
            }
        
            // Handle PDF file upload
            if ($this->File instanceof \Illuminate\Http\UploadedFile) {
                // Delete old PDF if exists
                if (!empty($this->ConnectBusinesses['File'])) {
                    if (Storage::disk('public')->exists($this->ConnectBusinesses['File'])) {
                        Storage::disk('public')->delete($this->ConnectBusinesses['File']);
                    }
                }
                // Upload new PDF
                $this->ConnectBusinesses['File'] = $this->File->store('pdfs', 'public');
            }
            
            $affectedRows = DB::table('ConnectBusinesses')
                ->where('id', $this->ConnectBusinesses_Id)
                ->update([
                    'Title' => $this->ConnectBusinesses['Title'],
                    'Description' => $this->ConnectBusinesses['Description'],
                    'Status' => $this->ConnectBusinesses['Status'],
                    'Banner' => $this->ConnectBusinesses['Banner'],
                    'File' => $this->ConnectBusinesses['File'],
                    'SubMenuId' => $this->ConnectBusinesses['SubMenuId'],
                    'ModifiDate' => now(),
                    'UserId' => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->id : (auth()->guard('user')->check() ? auth()->guard('user')->user()->id : null),
                ]);

            File::cleanDirectory(public_path('storage/livewire-tmp'));
            
            if ($affectedRows === 0) {
                throw new \Exception('No record was updated. Please check your inputs.');
            }
            connect_businesses_log(json_encode([
                'ID' => $this->ConnectBusinesses['id'] ?? null,
                'Title' => $this->ConnectBusinesses['Title'] ?? null,
                'UserID' => auth()->guard('admin')->user()->id ?? null,
                'UserEmail' => auth()->guard('admin')->user()->email ?? null,
                'Type'  =>  'Updated'
            ], JSON_PRETTY_PRINT));

            // Send email notification
            $emailService = app(EmailService::class);
            $user = auth()->guard('admin')->check() ? auth()->guard('admin')->user() : auth()->guard('user')->user();
            
            $emailData = [
                'title' => 'Business Connection Post Updated',
                'action' => 'Updated',
                'businessTitle' => $this->ConnectBusinesses['Title'],
                // 'description' => $this->ConnectBusinesses['Description'],
                // 'banner' => $this->ConnectBusinesses['Banner'],
                // 'file' => $this->ConnectBusinesses['File'],
                'modifiedBy' => $user->name ?? 'System',
                'date' => now()->format('Y-m-d H:i:s')
            ];

            // Send to admin
            $emailService->sendHtmlEmail(
                config('mail.from.address'),
                'Connect Business Post Updated',
                'emails.connect-businesses-notification',
                $emailData
            );

            // Send to the user who updated the post
            if ($user->email) {
                $emailService->sendHtmlEmail(
                    $user->email,
                    'Your Business Connection Post Has Been Updated',
                    'emails.connect-businesses-notification',
                    $emailData
                );
            }

            DB::commit();

            return redirect()->route('admin.connect.business')->with([
                'message' => __('Update Successful'),
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            // Delete files from storage
            if (!empty($this->ConnectBusinesses['Banner'])) {
                if (Storage::disk('public')->exists($this->ConnectBusinesses['Banner'])) {
                    Storage::disk('public')->delete($this->ConnectBusinesses['Banner']);
                }
            }
            
            if (!empty($this->ConnectBusinesses['File'])) {
                if (Storage::disk('public')->exists($this->ConnectBusinesses['File'])) {
                    Storage::disk('public')->delete($this->ConnectBusinesses['File']);
                }
            }
            
            // Delete record from database
            ConnectBusinesses::where('id', $this->ConnectBusinesses_Id)->delete();

            // Send email notification for deletion
            $emailService = app(EmailService::class);
            $user = auth()->guard('admin')->check() ? auth()->guard('admin')->user() : auth()->guard('user')->user();
            
            $emailData = [
                'title' => 'Business Connection Post Deleted',
                'action' => 'Deleted',
                'businessTitle' => $this->ConnectBusinesses['Title'],
                // 'description' => 'This post has been deleted.',
                // 'banner' => null,
                // 'file' => null,
                'modifiedBy' => $user->name ?? 'System',
                'date' => now()->format('Y-m-d H:i:s')
            ];

            // Send to admin
            $emailService->sendHtmlEmail(
                config('mail.from.address'),
                'Connect Business Post Deleted',
                'emails.connect-businesses-notification',
                $emailData
            );

            // Send to the user who deleted the post
            if ($user->email) {
                $emailService->sendHtmlEmail(
                    $user->email,
                    'Your Business Connection Post Has Been Deleted',
                    'emails.connect-businesses-notification',
                    $emailData
                );
            }

            DB::commit();

            return redirect()->route('admin.connect.business')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
