<div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">{{ $titleForm }}

                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div wire:ignore>
                                    <div class="form-group">
                                        <label for="name">Empleados</label>
                                        <select class="form-control select2" wire:model="idEmployee">
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div wire:ignore>
                                    <div class="form-group">
                                        <label for="price">Servicios</label>
                                        <select class="form-control select2-service" wire:model="idService">
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex; justify-content:space-between">
                            @if ($accion == 'Editar')
                                <button type="button" class="btn btn-primary"
                                    wire:click="updateAssignment">Actualizar</button>
                            @else
                                <button wire:click="$emit('store')" class="btn btn-success">Guardar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">Listado de asignaciones</h3>
                    </div>
                    <div class="card-img-top p-2" style="display: flex; justify-content:space-between">
                        <input type="search" class="form-control m-1" wire:model="search">
                        <select class="form-control m-1" wire:model="sortBy">
                            <option value="id_employee">Empleado</option>
                            <option value="id_service">Servicio</option>
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
                                <th>Empleado</th>
                                <th>Servicio</th>
                                <th>Acciones</th>
                            </tr>
                            @if (count($seremployee) > 0)
                                @foreach ($seremployee as $semploy)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="checked" value="{{ $semploy->id }}">
                                        </td>
                                        <td>{{ $semploy->oneEmployee->name ?? '' }}</td>
                                        <td>{{ $semploy->oneService->name ?? '' }}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="editAssignment({{ $semploy->id }})"
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
                                    <strong>Total:</strong> {{ $seremployee->total() }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $seremployee->links() }}
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
            // Capturar el evento para el cambio de selección
            $('.select2').on('change', function() {
                @this.set('idEmployee', $(this).val())
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.select2-service').select2()
            // Capturar el evento para el cambio de selección
            $('.select2-service').on('change', function() {
                @this.set('idService', $(this).val())
            })
        })
    </script>
@endsection
