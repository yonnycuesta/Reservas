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
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Precio</label>
                            <input type="number" class="form-control" wire:model="price" placeholder="Precio">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group" style="display: flex; justify-content:space-between">
                            @if ($accion == 'Editar')
                                <button type="button" class="btn btn-primary"
                                    wire:click="updateService">Actualizar</button>
                            @else
                                <button wire:click="serviceCreated" class="btn btn-success">Guardar</button>
                            @endif
                            <button wire:click="resetField" class="btn btn-secondary">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h3 class="card-title">Listado de servicios</h3>
                    </div>
                    <div class="card-img-top p-2" style="display: flex; justify-content:space-between">
                        <input type="search" class="form-control m-1" wire:model="search">
                        <select class="form-control m-1" wire:model="sortBy">
                            <option value="name">Nombre</option>
                            <option value="price">Precio</option>
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
                        <button type="button" wire:click="deleteService" class="btn btn-danger m-1">Eliminar</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                            @if (count($services) > 0)
                                @foreach ($services as $service)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="checked" value="{{ $service->id }}">
                                        </td>
                                        <td>{{ $service->name }}</td>
                                        <td>${{ $service->price }}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="editService({{ $service->id }})"
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
                                    <strong>Total:</strong> {{ $services->total() }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $services->links() }}
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
        window.addEventListener('service-create', event => {
            toastr.success(event.detail.message);
        })
    </script>
    <script>
        window.addEventListener('service-delete', event => {
            toastr.warning(event.detail.message);
        })
    </script>
    <script>
        window.addEventListener('service-update', event => {
            toastr.info(event.detail.message);
        })
    </script>
@endsection
