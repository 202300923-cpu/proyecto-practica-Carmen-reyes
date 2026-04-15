@extends('include.master')

@section('title','Inventory | Categorías')

@section('page-title','Lista de categorías')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12">

        <div class="card">

            <div class="header">
                <h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-category">
                        Nueva categoría
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

                {{-- BUSCADOR --}}
                <form method="GET" action="{{ url('category') }}">
                    <div class="row" style="margin-bottom:20px;">
                        
                        <div class="col-md-6">
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Buscar por nombre"
                                   value="{{ request('name') }}">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                Buscar
                            </button>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ url('category') }}" class="btn btn-default">
                                Limpiar
                            </a>
                        </div>

                    </div>
                </form>

                {{-- TABLA --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th width="120">Editar</th>
                                <th width="120">Eliminar</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($categories as $item)

                            <tr>
                                <td>{{ $item->name }}</td>

                                <td>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#edit-{{ $item->id }}">
                                        Editar
                                    </button>
                                </td>

                                <td>
                                    <form action="{{ url('category/delete/'.$item->id) }}"
                                          method="GET"
                                          onsubmit="return confirm('¿Eliminar categoría?');">

                                        <button class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- MODAL EDITAR --}}
                            <div class="modal fade" id="edit-{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form action="{{ url('category/update/'.$item->id) }}" method="POST">
                                            

                                            <div class="modal-header">
                                                <h4>Editar categoría</h4>
                                            </div>

                                            <div class="modal-body">
                                                <input type="text"
                                                       name="name"
                                                       class="form-control"
                                                       value="{{ $item->name }}"
                                                       required>
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
                                <td colspan="3" class="text-center">No hay categorías</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="create-category">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ url('category') }}" method="POST">
                

                <div class="modal-header">
                    <h4>Nueva categoría</h4>
                </div>

                <div class="modal-body">
                    <input type="text" name="name" class="form-control" required>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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