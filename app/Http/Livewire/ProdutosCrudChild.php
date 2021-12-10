<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\Marca;

class ProdutosCrudChild extends Component
{

    public $item;

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];

    /**
     * @var array
     */
    public $fornecedor = [];
    /**
     * @var array
     */
    public $checkedFornecedor = [];

    /**
     * @var array
     */
    public $marcas = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.nome' => '',
        'item.preco' => 'required|numeric',
        'item.quantidade' => 'numeric',
        'item.marca_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.nome' => 'Nome',
        'item.preco' => 'Preço',
        'item.quantidade' => 'Quantidade',
        'item.marca_id' => 'Marca',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    /**
     * @var string | int
     */
    public $primaryKey;

    /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.produtos-crud-child');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Produto::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('produtos-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Produto excluído');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->fornecedor = Fornecedor::orderBy('nome_fantasia')->get();
        $this->checkedFornecedor = [];

        $this->marcas = Marca::orderBy('nome')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Produto::create([
            'nome' => $this->item['nome'] ?? '', 
            'preco' => $this->item['preco'] ?? '', 
            'quantidade' => $this->item['quantidade'] ?? '', 
            'marca_id' => $this->item['marca_id'] ?? 0, 
        ]);
        $item->fornecedor()->attach($this->checkedFornecedor);

        $this->confirmingItemCreation = false;
        $this->emitTo('produtos-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Produto adicionado');
    }
 
    public function showEditForm(Produto $produto): void
    {
        $this->resetErrorBag();
        $this->item = $produto;
        $this->confirmingItemEdit = true;

        $this->checkedFornecedor = $produto->fornecedor->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->fornecedor = Fornecedor::orderBy('nome_fantasia')->get();


        $this->marcas = Marca::orderBy('nome')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();

        $this->item->fornecedor()->sync($this->checkedFornecedor);
        $this->checkedFornecedor = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('produtos-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Produto atualizado');
    }

}
