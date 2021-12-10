<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Marca;

class MarcasCrudChild extends Component
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
    protected $rules = [
        'item.nome' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.nome' => 'Nome',
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
        return view('livewire.marcas-crud-child');
    }

    public function showDeleteForm(int $id): void
    {
        $this->confirmingItemDeletion = true;
        $this->primaryKey = $id;
    }

    public function deleteItem(): void
    {
        Marca::destroy($this->primaryKey);
        $this->confirmingItemDeletion = false;
        $this->primaryKey = '';
        $this->reset(['item']);
        $this->emitTo('marcas-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Marca excluída com sucesso');
    }
 
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Marca::create([
            'nome' => $this->item['nome'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->emitTo('marcas-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Marca adicionada com sucesso');
    }
 
    public function showEditForm(Marca $marca): void
    {
        $this->resetErrorBag();
        $this->item = $marca;
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $this->item->save();
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->emitTo('marcas-crud', 'refresh');
        $this->emitTo('livewire-toast', 'show', 'Marca atualizada com sucesso');
    }

}
