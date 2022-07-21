<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceComponent extends Component
{
    // Variables
    public $name, $price, $idService;
    public $checked = [];
    public $perPage = 5;
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = true;

    // Trait
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $titleForm = 'Nuevo Servicio', $accion = 'Agregar';

    public function render()
    {
        return view('livewire.admin.service-component', [
            'services' => Service::scopeSearch($this->search)
                ->orderBy($this->sortBy, $this->sortDirection ? 'desc' : 'asc')
                ->paginate($this->perPage),
        ])->extends('adminlte::page')->section('content');
    }

    protected $rules = [
        'name' => 'required|string|max:255|unique:services',
        'price' => 'required|numeric',
    ];

    protected $messages = [
        'name.required' => 'El nombre es requerido',
        'name.string' => 'El nombre debe ser una cadena de texto',
        'name.max' => 'El nombre debe tener máximo 255 caracteres',
        'name.unique' => 'El nombre ya existe',
        'price.required' => 'El precio es requerido',
        'price.numeric' => 'El precio debe ser un número',
    ];

    public function resetField()
    {
        $this->reset(); // reset all fields
    }

    protected function updated($field)
    {
        $this->validateOnly($field, $this->rules, $this->messages);
    }

    /**
     *Valida el formulario, crea un nuevo servicio, envía un evento del navegador y
     * reinicia el formulario
     */
    public function serviceCreated()
    {
        $this->validate();
        Service::create([
            'name' => $this->name,
            'price' => $this->price,
        ]);
        $this->dispatchBrowserEvent('service-create', [
            'title' => 'Servicio creado',
            'message' => '¡Datos guardados exitosamente!',
            'status' => 'success',
            'timer' => 3000,
        ]);
        $this->resetField();
    }

    public function deleteService()
    {
        Service::destroy($this->checked);
  
        $this->dispatchBrowserEvent('service-delete', [
            'title' => 'Servicio eliminado',
            'message' => '¡Datos eliminados exitosamente!',
            'status' => 'warning',
            'timer' => 3000,
        ]);
    }

    public function editService($id)
    {
        $this->titleForm = 'Editar Servicio';
        $this->accion = 'Editar';
        $service = Service::find($id);
        $this->idService = $service->id;
        $this->name = $service->name;
        $this->price = $service->price;
    }

    public function updateService()
    {
        $service = Service::find($this->idService);

        $this->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $this->idService,
            'price' => 'required|numeric',
        ]);
        if ($service) {
            $service->update([
                'name' => $this->name,
                'price' => $this->price,
            ]);
        } else {
            return redirect()->back();
        }
        $this->dispatchBrowserEvent('service-update', [
            'title' => 'Servicio actualizado',
            'message' => '¡Datos actualizados exitosamente!',
            'status' => 'info',
            'timer' => 3000,
        ]);
        $this->resetField();
    }
}
