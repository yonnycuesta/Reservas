<div>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mt-2">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">{{ $titleForm }} </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" wire:model="customer_name"
                                        placeholder="Ingresar nombre">
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <input type="email" class="form-control" wire:model="customer_email"
                                        placeholder="Ingresar correo electrónico">
                                    @error('customer_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="tel" class="form-control" wire:model="customer_phone"
                                        placeholder="Ingresar número telefónico">
                                    @error('customer_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div wire:ignore class="form-group">
                                    <label for="employee">Empleados</label>
                                    <select wire:model="employeeId" class="form-control select2">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('employeeId')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if ($employeeId != 0)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="services">Servicios</label><br>
                                        @foreach ($services as $service)
                                            <li style="display:inline-block">
                                                <input type="checkbox" wire:model="servicios"
                                                    value="{{ $service->name }}"> {{ $service->name }}
                                            </li>
                                        @endforeach
                                        @error('serviceId')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile">Parte del dia</label><br>
                                    <input type="checkbox" wire:model="partMorning">
                                    <label for="am">AM</label>
                                    <input type="checkbox" wire:model="partAfternoon">
                                    <label for="pm">PM</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inning_hour">Hora</label>
                                    <input type="time" class="form-control InningTimepicker"
                                        wire:model="inning_hour">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inning_date">Fecha</label>
                                    <input type="date" class="form-control" wire:model="inning_date" min="2022-07-18"
                                        max="2022-12-31">
                                    @error('inning_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="file_attach">Datos Ajuntos</label>
                                    <input type="file" class="form-control form-control-file"
                                        wire:model="file_attach">
                                    @error('file_attach')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea wire:model="description" class="form-control" cols="10" rows="5"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex; justify-content:space-between">
                            @if ($accion == 'Editar')
                                <button type="button" class="btn btn-primary"
                                    wire:click="updateService">Actualizar</button>
                            @else
                                <button wire:click="$emit('store')" class="btn btn-success">Guardar</button>
                            @endif
                            <button wire:click="$emit('resetField')" class="btn btn-secondary">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 mt-2">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">Listado de turnos</h3>
                    </div>
                    <div class="card-img-top p-2" style="display: flex; justify-content:space-between">
                        <input type="search" class="form-control m-1" wire:model="search">
                        <select class="form-control m-1" wire:model="sortBy">
                            <option value="customer_name">Cliente</option>
                            <option value="employee_id">Empleado</option>
                        </select>
                        <select class="form-control m-1" wire:model="sortDirection">
                            <option value="1">Ascendente</option>
                            <option value="0">Descendente</option>
                        </select>
                        <select class="form-control m-1" wire:model="perPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">20</option>
                        </select>
                        <button type="button" wire:click="$emit('delete')" class="btn btn-danger m-1">Eliminar</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Cliente</th>
                                <th>Servicios</th>
                                <th>Empleado</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Acciones</th>
                            </tr>
                            @if (count($innings) > 0)
                                @foreach ($innings as $inning)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="checked" value="{{ $inning->id }}">
                                        </td>
                                        <td>{{ $inning->customer_name }}</td>
                                        <td>
                                            @php
                                                $names = $inning->service;
                                                // Guardamos el nombre en una array
                                                $names = explode(',', $names);
                                                // Recorremos el array
                                                foreach ($names as $name) {
                                                    echo $name . '<br>';
                                                }
                                            @endphp
                                        </td>
                                        <td>{{ $inning->employee->name ?? '' }}</td>
                                        <td>{{ $inning->inning_date }}</td>
                                        <td>{{ $inning->inning_hour }}{{ $inning->part_day }}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="editInning({{ $inning->id }})"
                                                class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p>
                                    No hay registros
                                </p>
                            @endif
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <strong>Total:</strong> {{ $innings->total() }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $innings->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2()
            $('.select2').on('change', function() {
                @this.set('employeeId', $(this).val())
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.InningTimepicker').timepicker({
                timeFormat: 'H:i',
                interval: 30,
                minTime: '00:00',
                maxTime: '23:59',
                defaultTime: '00:00',
                startTime: '00:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            }).on('changeTime', function() {
                @this.set('inning_hour', $(this).val())
            });
        })
    </script>
@endsection
