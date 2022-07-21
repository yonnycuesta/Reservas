<div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">{{ $titleForm }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Ingresar nombre">
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
                        <div class="form-group" style="display: flex; justify-content:space-between">
                            @if ($accion == 'Editar')
                                <button type="button" class="btn btn-primary"
                                    wire:click="updateCustomer">Actualizar</button>
                            @else
                                <button wire:click="customerCreated" class="btn btn-success">Guardar</button>
                            @endif
                            <button wire:click="$emit('resetField')" class="btn btn-secondary">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">Listado de clientes</h3>
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
                        <button type="button" wire:click="deleteCustomer" class="btn btn-danger m-1">Eliminar</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                            @if (count($customers) > 0)
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="checked" value="{{ $customer->id }}">
                                        </td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="editCustomer({{ $customer->id }})"
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
                                    <strong>Total:</strong> {{ $customers->total() }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $customers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
