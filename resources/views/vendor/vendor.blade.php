@extends('include.master')

@section('title','Inventory | Proveedores')

@section('page-title','Lista de Proveedores')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12">

        <div class="card">

            <div class="header">
                <h2>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create-vendor">
                        Nuevo proveedor
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
                <form method="GET" action="{{ url('proveedores') }}">
                    <div class="row" style="margin-bottom:20px;">

                        <div class="col-md-4">
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Buscar por nombre"
                                   value="{{ request('name') }}">
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   placeholder="Buscar por teléfono"
                                   value="{{ request('phone') }}">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary">Buscar</button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ url('proveedores') }}" class="btn btn-default">Limpiar</a>
                        </div>

                    </div>
                </form>

                {{-- TABLA --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vendors as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->address }}</td>

                            <td>
                                <button class="btn btn-info" data-toggle="modal" data-target="#edit-{{ $item->id }}">
                                    Editar
                                </button>
                            </td>

                            <td>
                                <form action="{{ url('proveedores/delete/'.$item->id) }}"
                                      method="GET"
                                      onsubmit="return confirm('¿Eliminar proveedor?')">
                                    <button class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDITAR --}}
                        <div class="modal fade" id="edit-{{ $item->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ url('proveedores/update/'.$item->id) }}" method="POST">

                                        <div class="modal-header">
                                            <h4>Editar proveedor</h4>
                                        </div>

                                        <div class="modal-body">

                                            <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                            <br>

                                            <input type="email" name="email" class="form-control" value="{{ $item->email }}">
                                            <br>

                                            <input type="text" name="phone" class="form-control" value="{{ $item->phone }}" required>
                                            <br>

                                            <input type="text" name="address" class="form-control" value="{{ $item->address }}">

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
                            <td colspan="6" class="text-center">No hay proveedores</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="create-vendor">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ url('proveedores') }}" method="POST">
        

                <div class="modal-header">
                    <h4>Nuevo proveedor</h4>
                </div>

                <div class="modal-body">

                    <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    <br>

                    <input type="email" name="email" class="form-control" placeholder="Correo">
                    <br>

                    <input type="text" name="phone" class="form-control" placeholder="Teléfono" required>
                    <br>

                    <input type="text" name="address" class="form-control" placeholder="Dirección">

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