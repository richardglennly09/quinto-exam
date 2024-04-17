<?php

namespace App\Livewire;

use App\Jobs\SendEmailJob;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class TaskListComponent extends Component
{
    public $tasks = [];

    public $id;
    public $name;
    public $description;
    public $dueDate;
    public $status = 1;

    public $modal = false;

    public $statuses = [];

    protected $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'dueDate' => 'required',
        'status' => 'required'
    ];

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount() {
        // $this->tasks = Task::with('status')->get();
        $this->statuses = Status::all();
    }

    public function showModal() {

        $this->modal = true;
    }

    public function closeModal() {

        $this->modal = false;

        $this->reset('id');
        $this->reset('name');
        $this->reset('dueDate');
        $this->reset('status');
        $this->reset('description');

        // $this->reset();
    }

    public function create() {
        $this->validate();

        DB::beginTransaction();
        try {
            //code...
            $taskData = [
                "name" => $this->name,
                "description" => $this->description,
                "due_date" => $this->dueDate,
                "status_id" => $this->status,
            ];

            if(!$this->id) {
                Task::create($taskData);

                $taskData['status'] = Status::find($this->status)->name;

                dispatch(new SendEmailJob($taskData, $this->id, []));
            } else {
                Task::find($this->id)->update($taskData);
            }
    
            $this->modal = false;
   
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;

        }
    }

    public function showEdit($id) {
        $this->dispatch('showModal', $id);
        // $task = Task::find($id);
        // $this->id = $id;
        // $this->name = $task->name;        
        // $this->description = $task->description;
        // // $this->dueDate = Carbon::parse($task->due_date)->format('mm/dd/yyyy');
        // $this->dueDate = Carbon::parse($task->due_date)->format('Y-m-d');
        // $this->status =$task->status_id;


        // $this->showModal();
    }

    public function render()
    {
        $this->tasks = Task::with('status')->limit(10)->get();

        return view('livewire.task-list-component');
    }
}
