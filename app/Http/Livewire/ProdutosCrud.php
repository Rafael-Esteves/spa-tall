<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\Produto;
use App\Models\Marca;
use App\Models\Fornecedor;

class ProdutosCrud extends Component
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
    public $columns = ['Nome', 'Marca', 'Preço', 'Quantidade', 'Fornecedor'];

    /**
     * @var array
     */
    public $selectedColumns = [];

    /**
     * @var array
     */
    public $filters = [];

    /**
     * @var array
     */
    public $selectedFilters = [];


    public function mount(): void
    {
        $this->selectedColumns = $this->columns;
        $this->initFilters();
    }

    public function render(): View
    {
        $results = $this->query()
            ->with(['fornecedor', 'marca'])
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('nome', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.produtos-crud', [
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

    public function updatingSelectedFilters(): void
    {
        $this->resetPage();
    }

    private function isFilterSet(string $column): bool
    {
        if (isset($this->selectedFilters[$column])) {
            if (is_array($this->selectedFilters[$column])) {
                if (!empty($this->selectedFilters[$column])) {
                    return true;
                }
            } else {
                if ($this->selectedFilters[$column] != '') {
                    return true;
                }
            }
        }
        return false;
    }

    public function resetFilters(): void
    {
        $this->reset('selectedFilters');
        $this->initMultiFilters();
    }

    private function initMultiFilters(): void
    {
    }

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function query(): Builder
    {
        return Produto::query()
            ->when($this->isFilterSet('marca_id'), function ($query) {
                return $query->where('marca_id', $this->selectedFilters['marca_id']);
            })
            ->when($this->isFilterSet('fornecedor_id'), function ($query) {
                return $query->whereHas('fornecedor', function ($query) {
                    return $query->where('fornecedors.id', $this->selectedFilters['fornecedor_id']);
                });
            });
    }
    private function initFilters(): void
    {


        $fornecedors = Fornecedor::pluck('nome', 'id')->map(function ($i, $k) {
            return ['key' => $k, 'label' => $i];
        })->toArray();
        $this->filters['fornecedor_id']['label'] = 'Fornecedor';
        //$this->filters['fornecedor_id']['multiple'] = true;
        $this->filters['fornecedor_id']['options'] = ['0' => ['key' => '', 'label' => 'Qualquer']] + $fornecedors;

        $marcas = Marca::pluck('nome', 'id')->map(function ($i, $k) {
            return ['key' => $k, 'label' => $i];
        })->toArray();
        $this->filters['marca_id']['label'] = 'Marca';
        //$this->filters['marca_id']['multiple'] = true;
        $this->filters['marca_id']['options'] = ['0' => ['key' => '', 'label' => 'Qualquer']] + $marcas;
        $this->initMultiFilters();
    }
}
