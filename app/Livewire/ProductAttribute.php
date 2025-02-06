<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Attribute;
use Livewire\Component;

class ProductAttribute extends Component
{
    public $product;
    public $productAttributes = [];
    public $newAttributeName;
    public $newAttributeValue;
    public $suggestedAttributes = [];



    public function removeAttribute($attributeId)
{
    // Eliminar la relación entre el producto y el atributo
    $this->product->attributes()->detach($attributeId);

    // Actualizar el listado de atributos del producto
    $this->productAttributes = $this->product->attributes->pluck('pivot.value', 'name')->toArray();
}


    public function mount($product, $productAttributes = [])
    {
        $this->product = $product;
        $this->productAttributes = $productAttributes;
    }

    public function render()
{
    $productAttributes = $this->product->attributes->mapWithKeys(function($attribute) {
        return [$attribute->name => $attribute->id];
    });

    return view('livewire.product-attribute', [
        'productAttributes' => $productAttributes,
    ]);
}


    public function addAttribute()
    {
        if ($this->newAttributeName && $this->newAttributeValue) {
            $attribute = Attribute::firstOrCreate(['name' => $this->newAttributeName]);
            $this->product->attributes()->attach($attribute->id, ['value' => $this->newAttributeValue]);

            $this->newAttributeName = '';
            $this->newAttributeValue = '';

            $this->productAttributes = $this->product->attributes->pluck('pivot.value', 'name')->toArray();
        }
    }

    public function updateSuggestions()
    {
        // Obtener los atributos ya asociados al producto
        $existingAttributes = $this->product->attributes->pluck('name')->toArray();

        if ($this->newAttributeName) {
            $this->suggestedAttributes = Attribute::where('name', 'like', '%' . $this->newAttributeName . '%')
                ->whereNotIn('name', $existingAttributes)  // Filtrar los que ya están asociados
                ->limit(5)
                ->get();
        } else {
            $this->suggestedAttributes = [];
        }
    }

    public function selectSuggestion($suggestionName)
    {
        $this->newAttributeName = $suggestionName;
        $this->suggestedAttributes = [];  // Vaciar las sugerencias
    }
}
