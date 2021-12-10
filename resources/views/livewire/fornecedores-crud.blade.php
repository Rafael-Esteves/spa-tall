<div class="min-h-screen mt-8">
    <div class="flex justify-between">
        <div class="text-2xl">Fornecedores</div>
        <button type="submit" wire:click="$emitTo('fornecedores-crud-child', 'showCreateForm');" class="text-blue-500">
            <x:tall-crud-generator::icon-add />
        </button> 
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div class="flex">

                <input wire:model.debounce.500ms="q" type="search" placeholder="Search" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" />
                <span class="mt-2 ml-3" wire:loading.delay wire:target="q">
                    <x:tall-crud-generator::loading-indicator />
                </span>                <x:tall-crud-generator::filter :filters=$filters />
            </div>
            <div class="flex">

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
                <td class="px-3 py-2" >CNPJ</td>
                <td class="px-3 py-2" >CPF</td>
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('nome')">Nome</button>
                        <x:tall-crud-generator::sort-icon sortField="nome" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('nome_fantasia')">Nome Fantasia</button>
                        <x:tall-crud-generator::sort-icon sortField="nome_fantasia" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >Produtos</td>
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('produtos_count')">Produtos Count</button>
                        <x:tall-crud-generator::sort-icon sortField="produtos_count" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->cnpj}}</td>
                    <td class="px-3 py-2" >{{ $result->cpf}}</td>
                    <td class="px-3 py-2" >{{ $result->nome}}</td>
                    <td class="px-3 py-2" >{{ $result->nome_fantasia}}</td>
                    <td class="px-3 py-2" >{{ $result->produtos->implode('nome', ',')}}</td>
                    <td class="px-3 py-2" >{{ $result->produtos_count}}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$emitTo('fornecedores-crud-child', 'showEditForm', {{ $result->id}});" class="text-green-500">
                            <x:tall-crud-generator::icon-edit />
                        </button>
                        <button type="submit" wire:click="$emitTo('fornecedores-crud-child', 'showDeleteForm', {{ $result->id}});" class="text-red-500">
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
    @livewire('fornecedores-crud-child')
    @livewire('livewire-toast')
</div>