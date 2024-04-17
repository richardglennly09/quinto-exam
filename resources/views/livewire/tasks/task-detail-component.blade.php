<div x-cloak x-show="$wire.modal" class="fixed top-0 left-0 z-30 w-full h-full py-12 overflow-x-hidden overflow-y-auto outline-none bg-gray-400/30 modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog" id="modal">
        <div role="alert" class="w-1/4 mx-auto bg-white rounded p-5">
            <form wire:submit="update" id="task-update">
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


                <select wire:model.defer="userId" class="w-full" placeholder>
                    <option value="0"> Select User</option>

                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{ $user->name}} </option>
                    @endforeach
                </select>

                </div>
                <button type="submit">{{ $id ? 'Update' : 'Create' }}</button>
                <button type="button" wire:click="closeModal">Cancel</button>

            </form>
        </div>
    </div>