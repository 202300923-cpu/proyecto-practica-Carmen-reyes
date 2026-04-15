@extends('include.master')

@section('title','Inventory | Accesorios')

@section('page-title','Lista de Accesorios')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12">

        <div class="card">

            <div class="header">
                <h2>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create-accesorio">
                        Accesorio nuevo
                    </button>
                </h2>
            </div>

            <div class="body">

                {{-- MENSAJES --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- FILTROS --}}
                <form method="GET" action="{{ url('accesorios') }}">
                    <div class="row" style="margin-bottom:20px;">

                        <div class="col-md-4">
                            <select name="category_id" class="form-control">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Buscar por nombre"
                                   value="{{ request('name') }}">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary">Buscar</button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ url('accesorios') }}" class="btn btn-default">Limpiar</a>
                        </div>

                    </div>
                </form>

                {{-- TABLA --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Nombre</th>
                            <th>Detalles</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($accesorios as $item)
                        <tr>
                            <td>{{ optional($item->category)->name }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->details }}</td>

                            <td>
                                <button class="btn btn-info" data-toggle="modal" data-target="#edit-{{ $item->id }}">
                                    Editar
                                </button>
                            </td>

                            <td>
                                <form action="{{ url('accesorios/delete/'.$item->id) }}"
                                      method="GET"
                                      onsubmit="return confirm('¿Eliminar?')">
                                    <button class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDITAR --}}
                        <div class="modal fade" id="edit-{{ $item->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ url('accesorios/update/'.$item->id) }}" method="POST">
                                      

                                        <div class="modal-header">
                                            <h4>Editar accesorio</h4>
                                        </div>

                                        <div class="modal-body">

                                            <label>Categoría</label>
                                            <select name="category_id" class="form-control" required>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <br>

                                            <label>Nombre</label>
                                            <input type="text"
                                                   name="product_name"
                                                   class="form-control"
                                                   value="{{ $item->product_name }}"
                                                   required>

                                            <br>

                                            <label>Detalles</label>
                                            <textarea name="details" class="form-control">{{ $item->details }}</textarea>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-primary">Guardar</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay accesorios</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

{{-- 🔥 MODAL CREAR --}}
<div class="modal fade" id="create-accesorio">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ url('accesorios') }}" method="POST">

                <div class="modal-header">
                    <h4>Nuevo accesorio</h4>
                </div>

                <div class="modal-body">

                    <label>Categoría</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <br>

                    <label>Nombre</label>
                    <input type="text" name="product_name" class="form-control" required>

                    <br>

                    <label>Detalles</label>
                    <textarea name="details" class="form-control"></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection