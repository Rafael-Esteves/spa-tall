<div class="min-h-screen mt-8">
    <div class="flex justify-between">
        <div class="text-2xl">Marcas</div>
        <button type="submit" wire:click="$emitTo('marcas-crud-child', 'showCreateForm');" class="text-blue-500">
            <x:tall-crud-generator::icon-add />
        </button> 
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div class="flex">

                <input wire:model.debounce.500ms="q" type="search" placeholder="Buscar" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" />
                <span class="mt-2 ml-3" wire:loading.delay wire:target="q">
                    <x:tall-crud-generator::loading-indicator />
                </span>
            </div>
            <div class="flex">

                <x:tall-crud-generator::dropdown class="flex items-center px-2 mr-4 border cursor-pointer justify-items border-rounded">
                    <x-slot name="trigger">
                        Colunas
                    </x-slot>

                    <x-slot name="content">
                        @foreach($columns as $c)
                        <x:tall-crud-generator::checkbox-wrapper class="mt-2">
                            <x:tall-crud-generator::checkbox wire:model="selectedColumns" value="{{ $c }}" /><x:tall-crud-generator::label class="ml-2">{{$c}}</x:tall-crud-generator::label>
                        </x:tall-crud-generator::checkbox-wrapper>
                        @endforeach
                    </x-slot>
                </x:tall-crud-generator::dropdown>
                <x:tall-crud-generator::select class="block w-1/10" wire:model="per_page">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </x:tall-crud-generator::select>
            </div>
        </div>
        <table class="w-full mt-4 whitespace-no-wrap" wire:loading.class.delay="opacity-50">
            <thead>
                <tr class="font-bold text-left bg-blue-400">
                @if($this->showColumn('Criada em'))
                <td class="px-3 py-2" >Criada em</td>
                @endif
                @if($this->showColumn('Nome'))
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('nome')">Nome</button>
                        <x:tall-crud-generator::sort-icon sortField="nome" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                @endif
                @if($this->showColumn('Atualizada em'))
                <td class="px-3 py-2" >Atualizada em</td>
                @endif
                @if($this->showColumn('Produtos'))
                <td class="px-3 py-2" >Produtos</td>
                @endif
                <td class="px-3 py-2" >Ações</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    @if($this->showColumn('Criada em'))
                    <td class="px-3 py-2" >{{ $result->created_at}}</td>
                    @endif
                    @if($this->showColumn('Nome'))
                    <td class="px-3 py-2" >{{ $result->nome}}</td>
                    @endif
                    @if($this->showColumn('Atualizada em'))
                    <td class="px-3 py-2" >{{ $result->updated_at}}</td>
                    @endif
                    @if($this->showColumn('Produtos'))
                    <td class="px-3 py-2" >{{ $result->produtos->implode('nome', ',')}}</td>
                    @endif
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$emitTo('marcas-crud-child', 'showEditForm', {{ $result->id}});" class="text-green-500">
                            <x:tall-crud-generator::icon-edit />
                        </button>
                        <button type="submit" wire:click="$emitTo('marcas-crud-child', 'showDeleteForm', {{ $result->id}});" class="text-red-500">
                            <x:tall-crud-generator::icon-delete />
                        </button>
                    </td>
               </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $results->links() }}
    </div>
    @livewire('marcas-crud-child')
    @livewire('livewire-toast')
</div>