<div>
    {{-- Stop trying to control. --}}
    @if ( session('error'))
  <div>
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
              Error
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
              <p>{{ session("error") }}</p>
            </div>
          </div>
    </div>
    @endif

    @include('livewire.includes.create-todo-box')
    @include('livewire.includes.search-box')
    <div id="todos-list">
       @foreach ($todos as $todo)
       @include('livewire.includes.todo-card')
       @endforeach
        <div class="my-2">
            <!-- Pagination goes here -->
            {{ $todos->links() }}
        </div>
    </div>
</div>
