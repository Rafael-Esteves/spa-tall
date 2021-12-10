<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Fornecedor;
use App\Models\Produto;

class FornecedoresCrudChild extends Component
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
    public $produtos = [];
    /**
     * @var array
     */
    public $checkedProdutos = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.cnpj' => '',
        'item.cpf' => '',
        'item.nome' => '',
        'item.nome_fantasia' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.cnpj' => 'CNPJ',
        'item.cpf' => 'CPF',
        'item.nome' => 'Nome',
        'item.nome_fantasia' => 'Nome Fantasia',
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
        return view('livewire.fornecedores-crud-child');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Fornecedor::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('fornecedores-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Fornecedor excluído');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->produtos = Produto::orderBy('nome')->get();
        $this->checkedProdutos = [];
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Fornecedor::create([
            'cnpj' => $this->item['cnpj'] ?? '', 
            'cpf' => $this->item['cpf'] ?? '', 
            'nome' => $this->item['nome'] ?? '', 
            'nome_fantasia' => $this->item['nome_fantasia'] ?? '', 
        ]);
        $item->produtos()->attach($this->checkedProdutos);

        $this->confirmingItemCreation = false;
        $this->emitTo('fornecedores-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Fornecedor criado');
    }
 
    public function showEditForm(Fornecedor $fornecedor): void
    {
        $this->resetErrorBag();
        $this->item = $fornecedor;
        $this->confirmingItemEdit = true;

        $this->checkedProdutos = $fornecedor->produtos->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->produtos = Produto::orderBy('nome')->get();

    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();

        $this->item->produtos()->sync($this->checkedProdutos);
        $this->checkedProdutos = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('fornecedores-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Fornecedor atualizado');
    }

}
