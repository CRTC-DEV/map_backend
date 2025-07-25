<?php

namespace App\Http\Livewire\Map\GroupMainFunction;

use App\Traits\LogsMapActivity;

use App\Models\Map\GroupMainFunction;
use App\Models\Map\MainFunction;
use App\Models\Map\GroupFunction;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;

class GroupMainFunctionDetailLive extends Component
{
    use WithFileUploads, LogsMapActivity;

    public $message;
    public $groupfunction_id;
    public $main_function_id;
    public $GroupMainFunction;
    public $GroupFunction = [];
    public $MainFunction = [];
    public $available_groupfunctions;
    public $available_mainfunctions;    
    public function rules()
    {
        return [

            'GroupMainFunction.GroupFunctionId'=> 'required|integer',
            'GroupMainFunction.MainFunctionId'=> 'required|integer',
            'GroupMainFunction.Status' => 'required|numeric',
            'GroupMainFunction.OrderIndex' => 'required|numeric',
            'GroupMainFunction.IsShowBothLocation' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        $this->logMapPageView('Group Main Function Detail Page');

        [$this->groupfunction_id, $this->main_function_id] = explode(",", $id);

        $this->GroupMainFunction = GroupMainFunction::where('GroupFunctionId', $this->groupfunction_id)
            ->where('MainFunctionId', $this->main_function_id)
            ->firstOrFail()
            ->toArray();


        $this->available_mainfunctions = (new MainFunction())->getAllFunction();
        $this->available_groupfunctions = (new GroupFunction())->getAllGroupFunctions();
    }

    public function render()
    {

        return view('livewire.map.group-mainfunction.group_mainfunction_edit');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Group Main Function Detail');

        $this->validate();
        // dd($this->MainFunction);
        DB::beginTransaction();
        
        try {
            // Tìm bản ghi cụ thể dựa trên GroupFunctionId và MainFunctionId
            $affectedRows = DB::table('GroupMainFunction')
                ->where('GroupFunctionId', $this->groupfunction_id)
                ->where('MainFunctionId', $this->main_function_id)
                ->update([                    'GroupFunctionId' => $this->GroupMainFunction['GroupFunctionId'],
                    'MainFunctionId' => $this->GroupMainFunction['MainFunctionId'],
                    'Status' => $this->GroupMainFunction['Status'],
                    'OrderIndex' => $this->GroupMainFunction['OrderIndex'],
                    'IsShowBothLocation' => $this->GroupMainFunction['IsShowBothLocation'],
                    'ModifiDate' => now(),
                ]);
    
            if ($affectedRows === 0) {
                throw new \Exception('No record was updated. Please check your inputs.');
            }
    
            DB::commit();
    
            return redirect()->route('group-mainfunction')->with([
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
        $this->logMapAttempt('DELETE', 'Group Main Function Detail');

        DB::beginTransaction();

        try {
            // Delete GroupMainFunction
            GroupMainFunction::where('GroupFunctionId', $this->groupfunction_id)
                ->where('MainFunctionId', $this->main_function_id)
                ->delete();

            DB::commit();

            return redirect()->route('group-mainfunction')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}