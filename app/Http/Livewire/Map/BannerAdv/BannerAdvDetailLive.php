<?php

namespace App\Http\Livewire\Map\BannerAdv;

use App\Traits\LogsMapActivity;

use App\Models\Map\BannerAdv;
use Livewire\Component;
use App\Models\ItemTitle;
use App\Models\ItemDescription;
use App\Models\Map\T2Location;
use Livewire\WithFileUploads;


class BannerAdvDetailLive extends Component
{

    use WithFileUploads, LogsMapActivity;
    public $message;
    public $banner_adv;
    public $banner_adv_id;
    public $item_title;
    public $t2_location;
    public $description;
    public $ImagePaths = [];
    public $IsVideo;

    public function rules()
    {
        return [
            'banner_adv.T2LocationId' => 'required|numeric',
            'banner_adv.TitleId' => 'required|numeric',
            'banner_adv.DescriptionId' => 'required|numeric',
            // 'banner_adv.UserId', 
            'banner_adv.Status' => 'required|numeric',
            'banner_adv.StartDate' => 'required',
            'banner_adv.ExpiryDate' => 'required|after:banner_adv.StartDate',

            'banner_adv.LinkURL'  => 'required|string',
            'banner_adv.VideoURL'  => '',

            'ImagePaths.*' => 'max:2048',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        $this->logMapPageView('Banner Adv Detail Page');

        $this->banner_adv_id = $id;
        //dd($this->banner_adv);
        // $this->banner_adv = BannerAdv::find($id);
        $this->ImagePaths = json_decode((new BannerAdv())->getBannerAdvById($this->banner_adv_id)->ImagePaths, true);
        $this->IsVideo = BannerAdv::find($id)->IsVideo;
    }

    public function render()
    {
        $obj_banner_adv = new BannerAdv();
        $this->banner_adv = $obj_banner_adv->getBannerAdvById($this->banner_adv_id);

        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getAllItems();

        $obj_description = new ItemDescription();
        $this->description = $obj_description->getAllItem();

        $obj_item_title = new T2Location();
        $this->t2_location = $obj_item_title->getAllT2Location();

        return view('livewire.map.banner-adv.banner_adv_edit');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Banner Adv Detail');

        $this->validate();
        $this->banner_adv['IsVideo'] = $this->IsVideo;

        if ($this->IsVideo == TYPE_IMAGE) {
            $uploadedPaths = [];
            $existingPaths = json_decode($this->banner_adv['ImagePaths'] ?? '[]', true);

            if ($this->ImagePaths) {
                foreach ($this->ImagePaths as $image) {
                    if (is_object($image)) {  // Ảnh mới
                        $uploadedPaths[] = $this->uploadImage($image);
                    } else {  // Ảnh cũ
                        $uploadedPaths[] = $image;
                    }
                }
            }

            // Xóa các ảnh cũ không còn trong danh sách mới
            foreach ($existingPaths as $oldPath) {
                if (!in_array($oldPath, $uploadedPaths)) {
                    $this->deleteUploadedFile($oldPath);
                }
            }

            $this->banner_adv['ImagePaths'] = json_encode($uploadedPaths);
            $this->banner_adv['VideoURL'] = null;
        } else {
            // Nếu chuyển sang video, xóa tất cả ảnh cũ
            $existingPaths = json_decode($this->banner_adv['ImagePaths'] ?? '[]', true);
            foreach ($existingPaths as $oldPath) {
                $this->deleteUploadedFile($oldPath);
            }

            $this->banner_adv['ImagePaths'] = null;
        }

        // Cập nhật dữ liệu
        $obj_banner_adv = new BannerAdv();
        $obj_banner_adv->updateBannerAdv($this->banner_adv, $this->banner_adv_id);

        return redirect()->route('banner-adv')->with(['message' => __('Insert completed'), 'status' => 'success']);
    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Banner Adv Detail');


        $obj_banner_adv = new BannerAdv();
        $obj_banner_adv->deletdBannerAdv($this->banner_adv, $this->banner_adv_id);

        return redirect()->route('banner-adv')->with(['message' => __('Deleted success'), 'status' => 'success']);
    }


    public function uploadImage($image)
    {
        return uploadMultipleImages([$image], 'img_banner')[0];
    }

    public function updatedImagePaths()
    {
        $uploadedPaths = [];
        $existingPaths = $this->ImagePaths ?? [];

        foreach ($existingPaths as $path) {
            if ($path instanceof \Livewire\TemporaryUploadedFile) {
                $uploadedPaths[] = $this->uploadImage($path);
            } else {
                $uploadedPaths[] = $path;
            }
        }

        // Xóa các file không còn trong danh sách mới
        foreach ($existingPaths as $oldPath) {
            if (!in_array($oldPath, $uploadedPaths)) {
                $this->deleteUploadedFile($oldPath);
            }
        }

        $this->ImagePaths = $uploadedPaths;
    }

    // Phương thức để xóa ảnh cũ
    public function deleteImage($index)
    {
        $pathToDelete = $this->ImagePaths[$index] ?? null;

        // Xóa ảnh khỏi mảng
        unset($this->ImagePaths[$index]);
        $this->ImagePaths = array_values($this->ImagePaths);

        // Xóa file nếu tồn tại
        if ($pathToDelete) {
            $this->deleteUploadedFile($pathToDelete);
        }
    }
    protected function deleteUploadedFile($filePath)
    {
        $fullPath = public_path($filePath); // Đường dẫn đầy đủ
        if (file_exists($fullPath)) {
            unlink($fullPath); // Xóa file
        }
    }
}
