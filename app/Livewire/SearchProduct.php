<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;

class SearchProduct extends Component
{

    public $query;
    public $search_results;
    public $how_many;

    public function mount() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function render() {
        return view('livewire.search-product');
    }

    public function updatedQuery() {
        $term = trim($this->query);
        if ($term === '') {
            $this->search_results = collect();
            return;
        }
        $this->search_results = Product::where(function ($q) use ($term) {
                $q->where('product_name', 'like', "%$term%")
                  ->orWhere('product_code', 'like', "%$term%");
            })
            ->orderByDesc('id')
            ->take($this->how_many)
            ->get();
    }

    public function loadMore() {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function selectProduct($productId) {
        $product = Product::find($productId);
        if ($product) {
            $this->dispatch('productSelected', $product);
        }
        $this->resetQuery();
    }
}
