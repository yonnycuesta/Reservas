<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Employee;
use App\Models\Admin\Service;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeComponent extends Component
{
    // Variables
    public $name, $email, $phone, $address, $profile, $idEmployee;
    public $checked = [], $perPage = 5, $search = '', $sortBy = 'name', $sortDirection = true;

    public $titleForm = 'Nuevo Empleado', $accion = 'Agregar';

    // Trait
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['resetField' => 'limpiarCampos'];

    public $services;

    public $idService = [];

    public function mount()
    {
        $this->services = Service::all();
    }
    public function render()
    {
        return view('livewire.admin.employee-component', [
            'employees' => Employee::scopeSearch($this->search)
                ->orderBy($this->sortBy, $this->sortDirection ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ])->extends('adminlte::page')->section('content');
    }

    protected $rules = [
        'name' => 'required|string|max:50',
        'email' => 'string|email|max:255|unique:employees',
        'phone' => 'required|string|max:25',
        'address' => 'string|max:255',
        'profile' => 'required|string|max:255',
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
        'profile.required' => 'El perfil es requerido',
        'profile.string' => 'El perfil debe ser una cadena de texto',
        'profile.max' => 'El perfil debe tener máximo 255 caracteres',
    ];

    protected function updated($field)
    {
        $this->validateOnly($field, $this->rules, $this->messages);
    }

    public function limpiarCampos()
    {
        $this->reset(['name', 'email', 'phone', 'address', 'profile']);
    }

    public function employeeCreated()
    {
        $this->validate();

        Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'profile' => $this->profile,
        ]);
        $this->limpiarCampos();
    }

    public function deleteEmployee()
    {
        Employee::destroy($this->checked);
    }

    public function editEmployee($id)
    {
        $employee = Employee::find($id);

        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->address = $employee->address;
        $this->profile = $employee->profile;
        $this->idEmployee = $employee->id;

        $this->titleForm = 'Editar Empleado';
        $this->accion = 'Editar';
    }

    public function updateEmployee()
    {
        $employee = Employee::find($this->idEmployee);
        $this->validate([
            'name' => 'required|string|max:50',
            'email' => 'string|email|max:255|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:25',
            'address' => 'string|max:255',
            'profile' => 'required|string|max:255'
        ]);

        Employee::find($this->idEmployee)->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'profile' => $this->profile

        ]);
        $this->limpiarCampos();
    }
}
