<div>

    <x:tall-crud-generator::confirmation-dialog wire:model="confirmingItemDeletion">
        <x-slot name="title">
            Excluir produto
        </x-slot>

        <x-slot name="content">
            Tem certeza que quer excluir este produto?
        </x-slot>

        <x-slot name="footer">
            <x:tall-crud-generator::button wire:click="$set('confirmingItemDeletion', false)">Cancelar</x:tall-crud-generator::button>
            <x:tall-crud-generator::button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Excluir</x:tall-crud-generator::button>
        </x-slot>
    </x:tall-crud-generator::confirmation-dialog>

    <x:tall-crud-generator::dialog-modal wire:model="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x:tall-crud-generator::label>Nome</x:tall-crud-generator::label>
                <x:tall-crud-generator::input class="block w-1/2 mt-1" type="text" wire:model.defer="item.nome" />
                @error('item.nome') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x:tall-crud-generator::label>Marca</x:tall-crud-generator::label>
                    <x:tall-crud-generator::select class="block w-full mt-1" wire:model.defer="item.marca_id">
                        <option value="">Please Select</option>
                        @foreach($marcas as $c)
                        <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach
                    </x:tall-crud-generator::select>
                    @error('item.marca_id') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
                </div>
            </div>
            <div class="mt-4">
                <x:tall-crud-generator::label>Preço</x:tall-crud-generator::label>
                <x:tall-crud-generator::input class="block w-1/2 mt-1" type="text" wire:model.defer="item.preco" />
                @error('item.preco') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
            </div>
            <div class="mt-4">
                <x:tall-crud-generator::label>Quantidade</x:tall-crud-generator::label>
                <x:tall-crud-generator::input class="block w-1/2 mt-1" type="text" wire:model.defer="item.quantidade" />
                @error('item.quantidade') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
            </div>

            <h2 class="mt-4">Fornecedor</h2>
            <x:tall-crud-generator::select multiple="multiple" wire:model.defer="checkedFornecedor">
            @foreach( $fornecedor as $c)
                <option value="{{ $c->id }}">{{$c->nome_fantasia}}</option>
            @endforeach
            </x:tall-crud-generator::select>
        </x-slot>

        <x-slot name="footer">
            <x:tall-crud-generator::button wire:click="$set('confirmingItemCreation', false)">Cancelar</x:tall-crud-generator::button>
            <x:tall-crud-generator::button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Cadastrar produto</x:tall-crud-generator::button>
        </x-slot>
    </x:tall-crud-generator::dialog-modal>

    <x:tall-crud-generator::dialog-modal wire:model="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x:tall-crud-generator::label>Nome</x:tall-crud-generator::label>
                <x:tall-crud-generator::input class="block w-1/2 mt-1" type="text" wire:model.defer="item.nome" />
                @error('item.nome') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x:tall-crud-generator::label>Marca</x:tall-crud-generator::label>
                    <x:tall-crud-generator::select class="block w-full mt-1" wire:model.defer="item.marca_id">
                        <option value="">Please Select</option>
                        @foreach($marcas as $c)
                        <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach
                    </x:tall-crud-generator::select>
                    @error('item.marca_id') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
                </div>
            </div>
            <div class="mt-4">
                <x:tall-crud-generator::label>Preço</x:tall-crud-generator::label>
                <x:tall-crud-generator::input class="block w-1/2 mt-1" type="text" wire:model.defer="item.preco" />
                @error('item.preco') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
            </div>
            <div class="mt-4">
                <x:tall-crud-generator::label>Quantidade</x:tall-crud-generator::label>
                <x:tall-crud-generator::input class="block w-1/2 mt-1" type="text" wire:model.defer="item.quantidade" />
                @error('item.quantidade') <x:tall-crud-generator::error-message>{{$message}}</x:tall-crud-generator::error-message> @enderror
            </div>

            <h2 class="mt-4">Fornecedor</h2>
            <x:tall-crud-generator::select multiple="multiple" wire:model.defer="checkedFornecedor">
            @foreach( $fornecedor as $c)
                <option value="{{ $c->id }}">{{$c->nome_fantasia}}</option>
            @endforeach
            </x:tall-crud-generator::select>
        </x-slot>

        <x-slot name="footer">
            <x:tall-crud-generator::button wire:click="$set('confirmingItemEdit', false)">Cancelar</x:tall-crud-generator::button>
            <x:tall-crud-generator::button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Salvar</x:tall-crud-generator::button>
        </x-slot>
    </x:tall-crud-generator::dialog-modal>
</div>
