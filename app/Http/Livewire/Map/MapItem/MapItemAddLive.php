<?php

namespace App\Http\Livewire\Map\MapItem;

use App\Models\ItemDescription;
use App\Models\Languages;
use App\Models\Translations;
use App\Models\ItemTitle;
use App\Models\Map\ItemType;
use App\Models\Map\MapItem;
use App\Models\Map\T2Location;
use App\Models\TextContent;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class MapItemAddLive extends Component
{
    use WithFileUploads;
    
    public $showTranslationInput = false;
    public $showTranslationDescripton = false;
    public $language;
    public $message;
    public $image;
    //public $map_item;
    public $map_item = ['Status' => 2,'Rank' =>1];
    public $t2location;
    public $item_title;
    public $description;
    public $title_text;
    public $description_text;
    public $textcontent_titile;
    public $textconten_description;
    public $text_content;
    public $ItemTitle;
    public $ItemDescription;
    public $translation;
    public $translation_description;
    public $t2_location_add;
    public $item_type;
    public $item_type_add;

    public function rules()
    {
        return [
            // 'map_item.TextContentId' => 'required|numeric',
            'map_item.CadId' => 'required',
            'map_item.KeySearch' => 'required',
            'map_item.Status' => 'required|numeric',
            'map_item.T2LocationId' => 'required|numeric',
            'map_item.TitleId' => 'required|numeric',
            'map_item.DescriptionId' => 'required|numeric',
            'map_item.ItemTypeId' => 'required|numeric',
            'map_item.Longitudes' => 'required',
            'map_item.Latitudes' => 'required',
            'map_item.AreaSide' => 'required|numeric',

            'title_text.OriginalText' => '',
            'title_text.OriginalLanguageId' => 'required',
            'description_text' => '',
            // 'select_language' => '',  
            'map_item.Rank' => 'required|numeric',
            'map_item.StoreHours' => '',  
            'map_item.Contact' => '',  
            'image' => 'nullable|image|max:2048',
            
        ];
    }

    public function messages()
    {
        return [
            'map_item.TitleId.required' => 'Please do not empty the row Choose Title Map Item',
        ];
    }

    public function mount()
    {
        $this->title_text['OriginalLanguageId'] = 1;
        // dd($this->item_title);
    }

    public function render()
    {
        $obj_t2location = new T2Location();
        $obj_title = new ItemTitle();
        $obj_description = new ItemDescription();
        $obj_text_content = new TextContent();
        $obj_item_type = new ItemType();
        $obj_language = new Languages();
        $this->language = $obj_language->getAllLanguages();
        $this->textcontent_titile = $obj_text_content->getTextContentForTitle();
        $this->textconten_description = $obj_text_content->getTextContentForDescription();
        $this->item_type = $obj_item_type->getAllItemTypes();
        $this->t2location = $obj_t2location->getAllT2Location();
        $this->item_title = $obj_title->getAllItemsWithTextContent();
        $this->description = $obj_description->getAllItemsDescriptionWithTextContent();
        // dd($this->description,$this->t2location, $this->item_title,$this->textcontent_titile->Id);

        return view('livewire.map.map-item.map_item_add');
    }

    public function save()
    {
        $this->validate();
        
        // Xử lý tải lên hình ảnh nếu có
        if ($this->image) {
            $this->map_item['ImgUrl'] = $this->uploadImage($this->image);
        }

        $obj_map_item = new MapItem();
        $obj_map_item->insertMapItem($this->map_item);

        return redirect()->route('map-item')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);
    }
    
    public function uploadImage($image)
    {
        return uploadImage($image, 'map_items');
    }

    public function addTitleTextContent()
    {
        // dd($this->title_text);
        $this->validate([
            'title_text.OriginalText' => 'required',
            'title_text.OriginalLanguageId' => 'required',
        ]);

        $this->title_text['Flg'] = TEXT_TITLE;
        // dd($this->title_text);
        $obj_title = new TextContent();
        $obj_title->insertTextContent($this->title_text);

        session()->flash('message', __('Insert Title Text Content'));
        session()->flash('status', 'success');

        $this->emit('titleTextAdded');
        $this->showTranslationInput = true;
        $this->emit('openItemTitleModal');
        // return redirect()->route('map-item')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }
    public function addItemtitle()
    {
        $this->validate([
            'ItemTitle.TextContentId' => 'required',
        ]);
        // dd($this->ItemTitle);
        $this->ItemTitle['status'] = ENABLE;
        $obj_item_title = new ItemTitle();
        $obj_item_title->insertItem($this->ItemTitle);

        session()->flash('message', __('Insert Item Title'));
        session()->flash('status', 'success');

        $this->emit('itemTitleAdded');
        $this->emit('closeItemTitleModal');
    }
    //add Translation Title
    public function addTranslation()
    {
        // $this->emit();
        $this->emit('openTranslationModal', $this->title_text['OriginalText']);
    }
    public function addTranslationDescription()
    {
        // $this->emit();
        $this->emit('openTranslationDescriptionModal', $this->description_text['OriginalText']);
    }
    public function saveTranslation()
    {
        // dd(1);
        $this->validate([
            'translation.LanguageId' => 'required',
            'translation.Translation' => 'required',
        ]);
        $obj_text_content = new TextContent();
        $this->translation['TextContentId'] = $obj_text_content->getLatedTextContentForTitle()->Id;
        $this->translation['Status'] = ENABLE;

        //insert Translation
        try {
            DB::transaction(function () {
                $obj_translation = new Translations();
                $obj_translation->insertTranslations($this->translation);

                session()->flash('message', __('Insert Item Title Translation'));
                session()->flash('status', 'success');

                $this->emit('closeTranslationModal');

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
    public function saveTranslationDescription()
    {
        // dd(1);
        $this->validate([
            'translation_description.LanguageId' => 'required',
            'translation_description.Translation' => 'required',
        ]);
        $obj_text_content = new TextContent();
        $this->translation_description['TextContentId'] = $obj_text_content->getLatedTextContentForDescription()->Id;
        $this->translation_description['Status'] = ENABLE;

        try {
            DB::transaction(function () {
                $obj_translation = new Translations();
                $obj_translation->insertTranslations($this->translation_description);

                session()->flash('message', __('Insert Item Description Translation'));
                session()->flash('status', 'success');

                $this->emit('closeTranslationDescriptionModal');
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
    public function addDescription()
    {

        $this->validate([
            'description_text.OriginalText' => 'required',
            'description_text.OriginalLanguageId' => '',
        ]);
        $this->description_text['OriginalLanguageId'] = 1;
        $this->description_text['Flg'] = TEXT_DESCRIPTION;

        $description_text = new TextContent();
        $description_text->insertTextContent($this->description_text);

        session()->flash('message', __('Insert Description Text Content'));
        session()->flash('status', 'success');

        $this->emit('DescriptionTextAdded');
        $this->showTranslationDescripton = true;
        $this->emit('openDescriptionModal');
    }
    public function addItemDescription()
    {
        $this->validate([
            'ItemDescription.TextContentId' => 'required',
        ]);
        // dd($this->ItemTitle);
        $this->ItemDescription['status'] = ENABLE;
        $obj_item_title = new ItemDescription();
        $obj_item_title->insertItem($this->ItemDescription);

        session()->flash('message', __('Insert Item Description'));
        session()->flash('status', 'success');

        $this->emit('DescriptionTextAdded');
        $this->emit('closeItemTitleModal');
    }
    //T2Location
    public function addT2location(){
        $this->emit('openT2locationModal');
    }
    public function insertT2location(){
        $this->validate([
            't2_location_add.Name' => 'required',
            't2_location_add.Zone' => 'required|numeric',
            't2_location_add.Floor' => 'required',
            't2_location_add.Status'=> 'required'
        ]);

        try {
            DB::transaction(function () {
                $obj_t2location = new T2Location();
                $obj_t2location->insertT2Location($this->t2_location_add);

                session()->flash('message', __('Insert T2 Location'));
                session()->flash('status', 'success');

                $this->emit('closeT2locationModal');
            });
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', __('The T2 Location already exists.'));
                session()->flash('status', 'danger');
            } else {
                throw $e;
            }
        }
    }
    public function addItemType(){
        $this->emit('openItemTypeModal');

    }
    public function insertItemtype(){
        

        $this->validate([
            'item_type_add.Name' => 'required',
            'item_type_add.Description' => 'required',
            'item_type_add.Status'=> 'required'
        ]);

        try {
            DB::transaction(function () {
                $obj_itemtype = new ItemType();
                $obj_itemtype->insertItemType($this->item_type_add);

                session()->flash('message', __('Insert Item Type'));
                session()->flash('status', 'success');

                $this->emit('closeItemTypeModal');
            });
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('message', __('The Item Type already exists.'));
                session()->flash('status', 'danger');
            } else {
                throw $e;
            }
        }
    }
}
