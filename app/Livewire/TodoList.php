<?php

namespace App\Livewire;

use App\Models\Todo;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;
    public $search;

    public $editingTodoId;

    #[Rule('required|min:3|max:50')]
    public $editingTodoName;

    public function create(){
        // dd('test');

        // validate
        $validdated = $this->validateOnly('name');
        // create the tabel
        Todo::create($validdated); //we must add this protected $guarded =[]; to the TodoList model
        // clear the input
        $this->reset('name');
        // send flash message
        session()->flash('success','Created');
        $this->resetPage();
    }
    // public function delete(Todo $todo){
    //         $todo->delete();
    //     } or

    public function delete($todoId){
        try{
            Todo::findOrfail($todoId)->delete();
        }catch(Exception $e)
        {
            session()->flash('error','Failed to delete todo, it was alredy deleted !');
        }
    }

    public function toggle($todoId){
        $todo = Todo::find($todoId);
        $todo->comleted = !$todo->comleted;
        $todo->save();

    }

    public function edit($todoId){
        $this->editingTodoId = $todoId;
        $this->editingTodoName = Todo::find($todoId)->name;

    }

    public function cancelEdit(){
        $this->reset('editingTodoId','editingTodoName');
    }
    public function update(){
        $this->validateOnly('editingTodoName');
        Todo::find($this->editingTodoId)->update(
            [
            'name' => $this->editingTodoName
            ]
        );
        $this->cancelEdit();
    }

    public function render()
    {

        return view('livewire.todo-list',[
            'todos' => Todo::latest()
            ->where('name','like',"%{$this->search}%")
            ->paginate(5)
        ]);
    }
}
