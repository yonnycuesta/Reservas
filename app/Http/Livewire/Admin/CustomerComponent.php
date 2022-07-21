<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerComponent extends Component
{
    // Variables
    public $name, $email, $phone, $address, $idCustomer;
    public $checked = [], $perPage = 5, $search = '', $sortBy = 'name', $sortDirection = true;

    public $titleForm = 'Nuevo Cliente', $accion = 'Agregar';

    // Trait
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['resetField' => 'limpiarCampos'];

    public function render()
    {
        return view('livewire.admin.customer-component', [
            'customers' => Customer::scopeSearch($this->search)
                ->orderBy($this->sortBy, $this->sortDirection ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ])->extends('adminlte::page')->section('content');
    }

    protected $rules = [
        'name' => 'required|string|max:50',
        'email' => 'string|email|max:255|unique:customers',
        'phone' => 'required|string|max:25',
        'address' => 'string|max:255',
    ];

    protected $messages = [
        'name.required' => 'El nombre es requerido',
        'name.string' => 'El nombre debe ser una cadena de texto',
        'name.max' => 'El nombre debe tener máximo 50 caracteres',
        'email.string' => 'El email debe ser una cadena de texto',
        'email.email' => 'El email debe ser un email válido',
        'email.max' => 'El email debe tener máximo 255 caracteres',
        'email.unique' => 'El email ya existe',
        'phone.required' => 'El teléfono es requerido',
        'phone.string' => 'El teléfono debe ser una cadena de texto',
        'phone.max' => 'El teléfono debe tener máximo 25 caracteres',
        'address.string' => 'La dirección debe ser una cadena de texto',
        'address.max' => 'La dirección debe tener máximo 255 caracteres',
    ];


    protected function updated($field)
    {
        $this->validateOnly($field, $this->rules, $this->messages);
    }

    public function limpiarCampos()
    {
        $this->reset();
    }

    public function customerCreated()
    {
        $this->validate();
        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);
        $this->limpiarCampos();
    }

    public function deleteCustomer()
    {
        Customer::destroy($this->checked);
    }

    public function editCustomer($id)
    {
        $this->titleForm = 'Editar Cliente';
        $this->accion = 'Editar';
        $customer = Customer::find($id);
        $this->idCustomer = $customer->id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
    }

    public function updateCustomer()
    {
        $customer = Customer::find($this->idCustomer);
        $this->validate([
            'name' => 'required|string|max:50',
            'email' => 'string|email|max:255|unique:customers,email,' . $this->idCustomer,
            'phone' => 'required|string|max:25',
            'address' => 'string|max:255',
        ]);
        $customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);
        $this->limpiarCampos();
    }
}
