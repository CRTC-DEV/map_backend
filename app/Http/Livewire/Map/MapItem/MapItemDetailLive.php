<?php

namespace App\Http\Livewire\Map\MapItem;

use App\Models\ItemTitle;
use App\Models\Languages;
use App\Models\Map\MapItem;
use App\Models\ItemDescription;
use App\Models\Map\ItemType;
use App\Models\Map\T2Location;
use App\Models\TextContent;
use App\Models\Translations;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;

class MapItemDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $language;
    public $map_item;
    public $map_item_id;
    public $image;
    public $t2location;
    public $item_title;
    public $description;
    public $translation_title;
    public $translation_description;
    public $translation_des;
    public $translation;
    public $item_type;
    public function rules()
    {
        return [
            'map_item.CadId' => 'required',
            'map_item.KeySearch' => 'required',
            'map_item.Status' => 'required|numeric',
            'map_item.T2LocationId' => 'required|numeric',
            'map_item.TitleId' => 'required|numeric',
            'map_item.DescriptionId' => 'required|numeric',
            'map_item.ItemTypeId' => 'required|numeric',
            'map_item.Rank' => 'required|numeric',
            'map_item.AreaSide' => 'required|numeric',
            'map_item.UserId' => 'required|numeric',
            'map_item.Longitudes' => 'required',
            'map_item.Latitudes' => 'required',
            'map_item.StoreHours' => '',  
            'map_item.Contact' => '',
            'map_item.ImgUrl' => '',
            'image' => 'nullable|image|max:2048',

            'item_title.Text' => '',
            'item_title.TextcontentId'=> '',

            't2location.Name' =>'',
            't2location.Zone' =>'',
            't2location.Floor' =>'',
            't2location.Status' =>'',

            'item_type.Name' => '',
            'item_type.Description' => '',
            'item_type.IsShow' => '',
            'description.Text' => '',

              
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function mount($id)
    {
        $this->map_item_id = $id;
    }

    public function render()
    {
        $obj_map_item = new MapItem();
        $obj_t2location = new T2Location();
        $obj_title = new ItemTitle();
        $obj_description = new ItemDescription();
        $obj_translation = new Translations();
        $obj_item_type = new ItemType();
        $obj_language = new Languages();
        
        $this->map_item = $obj_map_item->getMapItemById($this->map_item_id);
        // dd($this->map_item);
        $this->item_title = $obj_title->getItemById($this->map_item->TitleId);
        $this->item_title['Text'] = $this->map_item->TitleText;

        $this->description = $obj_description->getItemById($this->map_item->DescriptionId);
        $this->description['Text'] = $this->map_item->DescriptionText;

        $this->translation_title = $obj_translation->getTranslationByTextContentId($this->item_title->TextContentId);
        $this->translation_des = $obj_translation->getTranslationByTextContentId($this->description->TextContentId);

        $this->t2location = $obj_t2location->getT2LocationById($this->map_item->T2LocationId);

        $this->item_type = $obj_item_type->getItemTypeById($this->map_item->ItemTypeId);
        $this->language = $obj_language->getAllLanguages();

        return view('livewire.map.map-item.map_item_edit');
    }

    public function save()
    {
        $this->validate();

        $this->map_item['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        
        // Xử lý tải lên hình ảnh mới nếu có
        if ($this->image) {
            // Xóa hình ảnh cũ nếu có
            if ($this->map_item->ImgUrl) {
                $this->deleteUploadedFile($this->map_item->ImgUrl);
            }
            
            // Lưu hình ảnh mới
            $this->map_item['ImgUrl'] = $this->uploadImage($this->image);
        }

        $obj_map_item = new MapItem();
        $obj_map_item->updateMapItem($this->map_item, $this->map_item_id);

        return redirect()->route('map-item')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);
    }

    public function delete()
    {
        $this->map_item->Status = DELETED_FLG;
        $obj_map_item = new MapItem();
        $obj_map_item->deleteMapItem(
            ['Status' => 3],
            $this->map_item_id
        );

        return redirect()->route('map-item')->with(['message' => __('be_msg.delete_success'), 'status' => 'success']);
    }
    public function editTitleTextContent(){
        // dd($this->item_title,$this->map_item);
        $obj_title = new ItemTitle();
        $item_title = $obj_title->getItemById($this->map_item->TitleId);
        $obj_textcontent = new TextContent();
        $textcontent = $obj_textcontent->getTextContentById($item_title->TextContentId);
        $textcontent->OriginalText = $this->item_title->Text;
        // dd($textcontent,$this->item_title->Text);
        $obj_textcontent->updateTextContent($textcontent, $textcontent->Id);

        return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Item Title updated successfully!','status' => 'success']);
    }
    public function editTranslationTitle($TextContentId,$LanguageId,$translation)
    {
        $obj_translation = new Translations();
        $old_translation = $obj_translation->getTranslationsBy2Id($TextContentId,$LanguageId);
        $old_translation->Translation = $translation;

        $obj_translation->updateTranslations($old_translation, $TextContentId,$LanguageId);
        
        return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Translation updated successfully!','status' => 'success']);
    }
    public function addTranslationTitle(){

        $this->emit('openTranslationModal', $this->item_title['OriginalText']);
    }
    public function saveTranslation()
    {
        $this->validate([
            'translation.LanguageId' => 'required',
            'translation.Translation' => 'required',
        ]);
        $obj_text_content = new TextContent();
        $obj_item_title = new ItemTitle();
        $itemtitle = $obj_item_title->getItemById($this->map_item->TitleId);
        $this->translation['TextContentId'] = $obj_text_content->getTextContentById($itemtitle->TextContentId)->Id;
        $this->translation['Status'] = ENABLE;

        //insert Translation
        try {
            DB::transaction(function () {
                $obj_translation = new Translations();
                $obj_translation->insertTranslations($this->translation);

                return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Translation insert successfully!','status' => 'success']);

            });
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', __('The translation already exists.'));
                session()->flash('status', 'danger');
            } else {
                throw $e;
            }
        }
    }

    public function editT2location(){
        // dd(1);
        $this->validate([
            't2location.Name' =>'required',
            't2location.Zone' =>'required|numeric',
            't2location.Floor' =>'required|numeric',
            // 't2location.Status' =>'',
        ]);

        $obj_t2location = new T2Location();
        // $old_t2location = $obj_t2location->getT2LocationById($this->map_item->T2LocationId);
        // dd($old_t2location );
        $obj_t2location->updateT2Location($this->t2location, $this->map_item->T2LocationId);
        
        return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'T2location updated successfully!','status' => 'success']);

    }
    public function editItemType(){
        $this->validate([
            'item_type.Name' => 'required',
            'item_type.Description' => 'required',
            'item_type.IsShow' => 'required|numeric',
        ]);

        $obj_itemtype = new ItemType();
        $obj_itemtype->updateItemType($this->item_type, $this->map_item->ItemTypeId);
        
        return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Item Type updated successfully!','status' => 'success']);

    }

    public function editItemDescriptionTextContent(){

        $obj_item_description = new ItemDescription();
        $item_description = $obj_item_description->getItemById($this->map_item->DescriptionId);
        $obj_textcontent = new TextContent();
        $textcontent = $obj_textcontent->getTextContentById($item_description->TextContentId);
        $textcontent->OriginalText = $this->description->Text;

        $obj_textcontent->updateTextContent($textcontent, $textcontent->Id);

        return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Item Description updated successfully!','status' => 'success']);
    }

    public function editTranslationItemDescription($TextContentId,$LanguageId,$translation)
    {
        $obj_translation = new Translations();
        $old_translation = $obj_translation->getTranslationsBy2Id($TextContentId,$LanguageId);
        $old_translation->Translation = $translation;

        $obj_translation->updateTranslations($old_translation, $TextContentId,$LanguageId);
        
        return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Translation updated successfully!','status' => 'success']);
    }

    public function addTranslationDescription(){

        $this->emit('openTranslationDescriptionModal', $this->item_title['OriginalText']);
    }
    public function saveTranslationDescription()
    {
        // dd($this->translation_description);
        $this->validate([
            'translation_description.LanguageId' => 'required',
            'translation_description.Translation' => 'required',
        ]);

        $obj_text_content = new TextContent();
        $obj_item_des = new ItemDescription();
        $itemdes = $obj_item_des->getItemById($this->map_item->DescriptionId);
        $this->translation_description['TextContentId'] = $obj_text_content->getTextContentById($itemdes->TextContentId)->Id;
        $this->translation_description['Status'] = ENABLE;

        //insert Translation
        try {
            DB::transaction(function () {
                $obj_translation = new Translations();
                $obj_translation->insertTranslations($this->translation_description);

                return redirect()->route('map-item-edit',['id' =>$this->map_item_id ])->with(['message'=> 'Translation insert successfully!','status' => 'success']);

            });
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', __('The translation already exists.'));
                session()->flash('status', 'danger');
            } else {
                throw $e;
            }
        }
    }
    
    public function uploadImage($image)
    {
        return uploadImage($image, 'map_items');
    }
    
    protected function deleteUploadedFile($filePath)
    {
        $fullPath = public_path($filePath); // Đường dẫn đầy đủ
        if (file_exists($fullPath)) {
            unlink($fullPath); // Xóa file
        }
    }
}
