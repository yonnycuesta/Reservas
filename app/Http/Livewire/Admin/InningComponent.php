<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Employee;
use App\Models\Admin\Inning;
use App\Models\Admin\Service;
use App\Models\Admin\ServiceEmployee;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class InningComponent extends Component
{
    // Variables
    public $customer_name, $customer_email, $customer_phone, $inning_date, $inning_hour,
        $employeeId, $serviceId, $description,
        $checked = [], $perPage = 5, $search = '', $sortBy = 'customer_name',
        $sortDirection = true, $titleForm = 'Nuevo Turno', $accion = 'Agregar',
        $partMorning, $partAfternoon, $file_attach, $sql, $servicios = [],
        $employees, $services;

    /*Un Trait que le permite usar la paginación y cargar archivos. */
    use WithPagination;
    use WithFileUploads;

    /*Una forma de cambiar el tema de paginación. */
    protected $paginationTheme = 'bootstrap';

    /*Esta es una forma de escuchar eventos de otros componentes. */
    protected $listeners = ['resetField' => 'limpiarCampos', 'store' => 'inningCreated', 'delete' => 'inningDeleted'];

    // Methods
    public function mount()
    {
        $this->employees = Employee::all();
    }

    public function render()
    {
        /* Getting the services that the employee can do. */
        $this->sql = ServiceEmployee::select('id_service')->where('id_employee', $this->employeeId)->get();
        $this->services = Service::whereIn('id', $this->sql)->get();

        return view('livewire.admin.inning-component', [
            'innings' => Inning::scopeSearch($this->search)
                ->orderBy($this->sortBy, $this->sortDirection ? 'asc' : 'desc')
                ->paginate($this->perPage)->withQueryString(),
            'services' => $this->services,
        ])->extends('adminlte::page')->section('content');
    }

    protected $rules = [
        'customer_name' => 'required',
        'customer_email' => 'nullable|email',
        'customer_phone' => 'required',
        'inning_date' => 'required',
        'inning_hour' => 'required',
        'employeeId' => 'required|numeric',
        'serviceId' => 'required|numeric',
        'description' => 'nullable|max:500',
        'file_attach' => 'file|mimes:jpeg,png,jpg,gif,svg|nullable',
    ];
    protected $messages = [
        'customer_name.required' => 'El nombre del cliente es requerido',
        'customer_phone.required' => 'El teléfono del cliente es requerido',
        'inning_date.required' => 'La fecha del turno es requerida',
        'inning_hour.required' => 'La hora del turno es requerida',
        'employeeId.required' => 'El empleado es requerido',
        'employeeId.numeric' => 'El empleado debe ser numérico',
        'serviceId.required' => 'El servicio es requerido',
        'serviceId.numeric' => 'El servicio debe ser numérico',
        'description.max' => 'La descripción no debe superar los 500 caracteres',
        'file_attach.file' => 'El archivo debe ser una imagen',
        'file_attach.mimes' => 'El archivo debe ser una imagen',
    ];

    public function limpiarCampos()
    {
        $this->reset(['customer_name', 'customer_email', 'customer_phone', 'inning_date', 'inning_hour', 'description', 'partMorning', 'partAfternoon']);
    }

    protected function updated($field)
    {
        $this->validateOnly($field, $this->rules, $this->messages);
    }

    public function inningCreated()
    {
        $this->validate();

        /*Una forma de obtener el valor del botón de radio. */
        if ($this->partMorning == 'true') {
            $part_of_day = 'am';
        } else if ($this->partAfternoon == 'true') {
            $part_of_day = 'pm';
        }
        // Photo
        $file = $this->file_attach ? 'storage/' . $this->file_attach->store('inning', 'public') : null;
        // Convertir el array de servicios a un string
        $service = implode(',', $this->servicios);

        // Consultar si exite un inning donde el inning_date, inning_hour y part_of_day
        // son iguales a los que se ingresaron en el formulario
        $inning = Inning::where('inning_date', $this->inning_date)
            ->where('inning_hour', $this->inning_hour)
            ->where('part_day', $part_of_day)->first();

        // Si existe un inning con esos datos, entonces no se puede crear el inning
        if ($inning) {
            session()->flash('message', 'Ya existe un turno para esa fecha y hora');
            return redirect()->back();
        } else {
            Inning::create([
                'employee_id' => $this->employeeId,
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'service' => $service,
                'inning_date' => $this->inning_date,
                'inning_hour' => $this->inning_hour,
                'part_day' => $part_of_day,
                'description' => $this->description,
                'file_attachment' => $file,
            ]);
        }
        // Si no existe un inning con esos datos, entonces se puede crear el inning


        $this->limpiarCampos();
        return redirect()->back();
    }

    /**
     * It deletes the inning.
     *
     * @return A redirect to the previous page.
     */
    public function inningDeleted()
    {
        Inning::destroy($this->checked);
        return redirect()->back();
    }
}
