<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\Fornecedor;
use App\Models\Produto;

class FornecedoresCrud extends Component
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
    public $per_page = 15;

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
        $this->initFilters();
    }

    public function render(): View
    {
        $results = $this->query()
            ->with(['produtos'])
            ->withCount(['produtos'])
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('cnpj', 'like', '%' . $this->q . '%')
                        ->orWhere('cpf', 'like', '%' . $this->q . '%')
                        ->orWhere('nome', 'like', '%' . $this->q . '%')
                        ->orWhere('nome_fantasia', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.fornecedores-crud', [
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

    public function query(): Builder
    {
        return Fornecedor::query()

            ->when($this->isFilterSet('produtos_id'), function($query) {
                return $query->whereHas('produtos', function($query) {
                    return $query->where('produtos.id', $this->selectedFilters['produtos_id']);
                });
            })
;
    }
    private function initFilters(): void
    {


        $produtos = Produto::pluck('nome', 'id')->map(function($i, $k) {
            return ['key' => $k, 'label' => $i];
        })->toArray();
        $this->filters['produtos_id']['label'] = 'Produtos';
        //$this->filters['produtos_id']['multiple'] = true;
        $this->filters['produtos_id']['options'] = ['0' => ['key' => '', 'label' => 'Any']] + $produtos;
        $this->initMultiFilters();
    }

}
