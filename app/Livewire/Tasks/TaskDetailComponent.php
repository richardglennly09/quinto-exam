<?php

namespace App\Livewire\Tasks;

use App\Jobs\SendEmailJob;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTasks;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TaskDetailComponent extends Component
{

    public $id;
    public $name;
    public $description;
    public $dueDate;
    public $status = 1;
    public $userId;

    public $statuses = [];
    public $users = [];

    public $modal = false;

    protected $listeners = [
        'showModal' => 'show',
        'closeModal' => 'close'
    ];

    protected $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'dueDate' => 'required',
        'status' => 'required'
    ];
    
    public function mount() {
        $this->statuses = Status::all();        
        $this->users = User::all();
    }

    public function closeModal() {
        $this->modal = false;

        $this->reset('id');
        $this->reset('name');
        $this->reset('dueDate');
        $this->reset('status');
        $this->reset('description');


        //refresh the table list
        $this->dispatch('refresh');

    }

    public function show($id) {

        $task = Task::find($id);
        $this->id = $id;
        $this->name = $task->name;        
        $this->description = $task->description;
        // $this->dueDate = Carbon::parse($task->due_date)->format('mm/dd/yyyy');
        $this->dueDate = Carbon::parse($task->due_date)->format('Y-m-d');
        $this->status =$task->status_id;

        $userTasks= UserTasks::find($id);

        $this->userId = $userTasks ? $userTasks->id : null;

        $this->modal = true;

    }

    public function update() {
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

            Task::find($this->id)->update($taskData);

            if($this->userId && $this->userId > 0) {
                UserTasks::updateOrCreate([
                    'task_id' => $this->id,
                    'user_id' => $this->userId
                ],
                [
                    'task_id' => $this->id,
                    'user_id' => $this->userId
                ]);

                $user = User::find($this->userId);
                $taskData['status'] = Status::find($this->status)->name;

                dispatch(new SendEmailJob($taskData, $this->id, $user));
            }

            $this->closeModal();
   
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;

        }
    }

    public function render()
    {
        return view('livewire.tasks.task-detail-component');
    }
}
