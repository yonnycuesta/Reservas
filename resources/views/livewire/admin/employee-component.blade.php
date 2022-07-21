<div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">{{ $titleForm }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" wire:model="name"
                                        placeholder="Ingresar nombre">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <input type="email" class="form-control" wire:model="email"
                                        placeholder="Ingresar correo electrónico">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="tel" class="form-control" wire:model="phone"
                                        placeholder="Ingresar número telefónico">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <input type="text" class="form-control" wire:model="address"
                                        placeholder="Ingresar dirección">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="profile">Perfil</label>
                                    <textarea wire:model="profile" class="form-control" cols="30" rows="5"></textarea>
                                    @error('profile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="display: flex; justify-content:space-between">
                            @if ($accion == 'Editar')
                                <button type="button" class="btn btn-primary"
                                    wire:click="updateEmployee">Actualizar</button>
                            @else
                                <button wire:click="employeeCreated" class="btn btn-success">Guardar</button>
                            @endif
                            <button wire:click="$emit('resetField')" class="btn btn-secondary">Limpiar</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">Listado de empleados</h3>
                    </div>
                    <div class="card-img-top p-2" style="display: flex; justify-content:space-between">
                        <input type="search" class="form-control m-1" wire:model="search">
                        <select class="form-control m-1" wire:model="sortBy">
                            <option value="name">Nombre</option>
                            <option value="email">Email</option>
                            <option value="phone">Teléfono</option>
                            <option value="address">Dirección</option>
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
                        <button type="button" wire:click="deleteEmployee" class="btn btn-danger m-1">Eliminar</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                            @if ($employees->isNotEmpty())
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="checked" value="{{ $employee->id }}">
                                        </td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="editEmployee({{ $employee->id }})"
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
                                    <strong>Total:</strong> {{ $employees->total() }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $employees->links() }}
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
                @this.set('idService', $(this).val())
            })
        })
    </script>
@endsection
