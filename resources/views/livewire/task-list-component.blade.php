<div class="m-20">

    <div class="flex flex-col w-full">

        <div class="w-full py-2 px-5">
            <x-button outline primary label="Create Tasks" wire:click="showModal" />
        </div>
        <table aria-label="rbTable" class="w-full h-full mb-0 border border-collapse border-slate-300" wire:key="test">
            <thead>
                <tr>
                    <th scope="col" class="w-24 px-3 py-4 text-xs font-medium border rounded-tl-lg border-slate-300">Name</th>
                    <th scope="col" class="w-48 px-3 py-4 text-xs font-medium border border-slate-300">Due</th>
                    <th scope="col" class="w-48 px-3 py-4 text-xs font-medium border border-slate-300">Description</th>
                    <th scope="col" class="w-48 px-3 py-4 text-xs font-medium border border-slate-300">Status</th>
                    <th scope="col" class="w-24 px-3 py-1 text-xs font-medium border rounded-tl-lg border-slate-300">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $key => $task)
                <tr class="{{$loop->odd ? 'bg-gray-100' :' bg-white'}}">
                    <td class="px-4 py-2 text-sm font-normal text-center text-gray-500 border border-gray-200 whitespace-nowrap" scope="row">
                        {{ $task->name}}
                    </td>
                    <td class="px-4 py-2 text-sm font-normal text-center text-gray-500 border border-gray-200 whitespace-nowrap" scope="row">
                        {{ $task->due_date}}
                    </td>
                    <td class="px-4 py-2 text-sm font-normal text-center text-gray-500 border border-gray-200 whitespace-nowrap" scope="row">
                        {{ $task->description}}
                    </td>
                    <td class="px-4 py-2 text-sm font-normal text-center text-gray-500 border border-gray-200 whitespace-nowrap" scope="row">
                        {{ $task->status->name}}
                    </td>
                    <td class="px-4 py-2 text-sm font-normal border border-gray-200 whitespace-nowrap" scope="row">
                            <x-button outline primary label="Edit" wire:click="showEdit({{$task->id}})" />
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap " colspan="8">No Record Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-cloak x-show="$wire.modal" class="fixed top-0 left-0 z-30 w-full h-full py-12 overflow-x-hidden overflow-y-auto outline-none bg-gray-400/30 modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog" id="modal">
        <div role="alert" class="w-1/4 mx-auto bg-white rounded p-5">
            <form wire:submit="create" id="tasks">
                <div class="my-2">
                    <x-input type="text" placeholder="Enter Tasks" wire:model.defer="name" />
                    <div>
                        @error('name') <span> {{ $message }} @enderror
                    </div>

                </div>
                <div class="my-2">
                    <x-textarea wire:model.defer="description" placeholder="Enter description"></x-textarea>
                    <div>
                        @error('description') <span> {{ $message }} @enderror
                    </div>
                </div>

                <div class="my-2">
                    <x-input type="date" placeholder="Select due date" wire:model.defer="dueDate"/>
                    
                    <div>
                        @error('dueDate') <span> {{ $message }} @enderror
                    </div>
                </div>

                <div class="my-2">

                <select wire:model.defer="status" class="w-full">
                    @foreach($statuses as $status)
                    <option value="{{$status->id}}">{{ $status->name}} </option>
                    @endforeach
                </select>

                </div>
                <button type="submit">{{ $id ? 'Update' : 'Create' }}</button>
                <button type="button" wire:click="closeModal">Cancel</button>

            </form>
        </div>
    </div>

    <livewire:tasks.task-detail-component />

</div>