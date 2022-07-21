<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Employee;
use App\Models\Admin\Service;
use App\Models\Admin\ServiceEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceEmployeeComponent extends Component
{
    // Variables
    public $idService, $idEmployee, $idAssigned;
    public $checked = [], $perPage = 5, $search = '', $sortBy = 'id_employee', $sortDirection = true;

    public $titleForm = 'Nueva Asignación', $accion = 'Agregar';

    // Trait
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $employees, $services;

    protected $listeners = ['store' => 'createAssignment', 'delete' => 'deleteAssignment'];

    public function mount()
    {
        $this->employees = Employee::all();
        $this->services = Service::all();
    }

    public function render()
    {
        return view('livewire.admin.service-employee-component', [
            'seremployee' => ServiceEmployee::scopeSearch($this->search)
                ->orderBy($this->sortBy, $this->sortDirection ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ])->extends('adminlte::page')->section('content');
    }

    protected $rules = [
        'idService' => 'required|integer',
        'idEmployee' => 'required|integer',
    ];
    protected $messages = [
        'idService.required' => 'El servicio es requerido',
        'idService.integer' => 'El servicio debe ser un número entero',
        'idEmployee.required' => 'El empleado es requerido',
        'idEmployee.integer' => 'El empleado debe ser un número entero',
    ];

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules, $this->messages);
    }

    public function createAssignment()
    {
        $this->validate();

        ServiceEmployee::create([
            'id_service' => $this->idService,
            'id_employee' => $this->idEmployee,
        ]);
    }

    public function editAssignment($id)
    {
        $assignment = ServiceEmployee::find($id);
        $this->idService = $assignment->id_service;
        $this->idEmployee = $assignment->id_employee;

        $this->idAssigned = $assignment->id;
        $this->accion = 'Editar';
        $this->titleForm = 'Editar Asignación';
    }
    public function updateAssignment()
    {
        $this->validate();
        $assignment = ServiceEmployee::find($this->idAssigned);
        $assignment->id_service = $this->idService;
        $assignment->id_employee = $this->idEmployee;
        $assignment->update();
    }
    public function deleteAssignment()
    {
        ServiceEmployee::destroy($this->checked);
    }
}
