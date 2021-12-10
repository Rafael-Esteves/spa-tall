<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\Marca;

class MarcasCrud extends Component
{
    use WithPagination;

    /**
     * @var array
     */
    protected $listeners = ['refresh' => '$refresh'];
    /**
     * @var string
     */
    public $sortBy = 'nome';

    /**
     * @var bool
     */
    public $sortAsc = true;

    /**
     * @var string
     */
    public $q;

    /**
     * @var int
     */
    public $per_page = 10;

    /**
     * @var array
     */
    public $columns = ['Criada em','Nome','Atualizada em','Produtos'];

    /**
     * @var array
     */
    public $selectedColumns = [];


    public function mount(): void
    {
        $this->selectedColumns = $this->columns;
    }

    public function render(): View
    {
        $results = $this->query()
            ->with(['produtos'])
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('nome', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.marcas-crud', [
            'results' => $results
        ]);
    }

    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function query(): Builder
    {
        return Marca::query();
    }
}
