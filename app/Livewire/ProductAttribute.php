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
    public $editingAttributeId;
    public $attributeValue;
    public $confirmingAttributeDelete = false;
    public $attributeToDelete;
    public $editingModal = false;

    public function mount($product)
    {
        $this->product = $product;
        $this->loadAttributes(); // carga inicial
    }


    public function render()
    {
        // Asegurarte de que la propiedad pública esté actualizada (si no lo está)
        if (empty($this->productAttributes)) {
            $this->loadAttributes();
        }

        return view('livewire.product-attribute', [
            'productAttributes' => $this->productAttributes,
        ]);
    }


    public function addAttribute()
    {
        $this->validate([
            'newAttributeName' => 'required|string|max:255',
            'newAttributeValue' => 'required|string|max:255',
        ]);

        $attribute = Attribute::firstOrCreate(['name' => $this->newAttributeName]);

        // Usar syncWithoutDetaching para evitar duplicados
        $this->product->attributes()->syncWithoutDetaching([
            $attribute->id => ['value' => $this->newAttributeValue]
        ]);

        $this->reset(['newAttributeName', 'newAttributeValue']);
        $this->suggestedAttributes = [];
        $this->loadAttributes();

        session()->flash('message', 'Atributo agregado correctamente.');
    }

    public function editAttribute($attributeId, $newValue)
    {
        $this->validate([
            'attributeValue' => 'required|string|max:255',
        ]);

        $this->product->attributes()->updateExistingPivot($attributeId, ['value' => $newValue]);
        $this->editingAttributeId = null;
        $this->editingModal = false;
        $this->loadAttributes();

        session()->flash('message', 'Atributo actualizado correctamente.');
    }

    public function confirmDeleteAttribute($attributeId)
    {
        $this->attributeToDelete = $attributeId;
        $this->confirmingAttributeDelete = true;
    }

    public function removeAttribute($attributeId)
    {
        $this->product->attributes()->detach($attributeId);
        $this->confirmingAttributeDelete = false;
        $this->attributeToDelete = null;
        $this->loadAttributes();

        session()->flash('message', 'Atributo eliminado correctamente.');
    }

    public function updateSuggestions()
    {
        $existingAttributes = $this->product->attributes->pluck('name')->toArray();

        if (strlen($this->newAttributeName) >= 2) {
            $this->suggestedAttributes = Attribute::where('name', 'like', '%' . $this->newAttributeName . '%')
                ->whereNotIn('name', $existingAttributes)
                ->limit(5)
                ->get();
        } else {
            $this->suggestedAttributes = [];
        }
    }

    public function selectSuggestion($name)
    {
        $this->newAttributeName = $name;
        $this->suggestedAttributes = [];
    }

    public function openEditModal($attributeId)
    {
        $this->editingAttributeId = $attributeId;

        // Buscar el nombre del atributo por su ID
        foreach ($this->productAttributes as $name => $data) {
            if (isset($data['id']) && $data['id'] == $attributeId) {
                $this->attributeValue = $data['value'];
                break;
            }
        }

        $this->editingModal = true;
    }


    protected function loadAttributes()
    {
        $this->productAttributes = $this->product->fresh()->attributes->mapWithKeys(function ($attribute) {
            return [$attribute->name => [
                'value' => $attribute->pivot->value,
                'id' => $attribute->id
            ]];
        })->toArray();
    }
}
