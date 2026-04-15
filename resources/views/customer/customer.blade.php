@extends('include.master')

@section('title','Inventory | Clientes')
@section('page-title','Todos los clientes')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="header">
                <h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-customer">
                        Cliente nuevo
                    </button>
                </h2>
            </div>

            <div class="body">
                <form method="GET" action="{{ route('customer.index') }}">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Buscar por nombre" value="{{ request('name') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Buscar por correo" value="{{ request('email') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="Buscar por teléfono" value="{{ request('phone') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix" style="margin-bottom: 15px;">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                            <a href="{{ route('customer.index') }}" class="btn btn-default">Limpiar</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo electrónico</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Importe comprado</th>
                                <th>Importe pagado</th>
                                <th>Importe debido</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->total_amount }}</td>
                                    <td>{{ $customer->total_paid_amount }}</td>
                                    <td>{{ $customer->total_amount - $customer->total_paid_amount }}</td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-primary btn-circle waves-effect waves-circle waves-float"
                                                data-toggle="modal"
                                                data-target="#edit-customer-{{ $customer->id }}">
                                            <i class="material-icons">edit</i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal editar -->
                                <div class="modal fade" id="edit-customer-{{ $customer->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ url('customer/update/'.$customer->id) }}">
                                                {{ csrf_field() }}

                                                <div class="modal-header">
                                                    <h4 class="modal-title">Editar cliente</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <input type="text" name="customer_name" class="form-control" value="{{ $customer->customer_name }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Correo electrónico</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Teléfono</label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Dirección</label>
                                                        <textarea name="address" class="form-control" rows="3">{{ $customer->address }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay clientes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    {{ $customers->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal crear -->
<div class="modal fade" id="create-customer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('customer.store') }}">
                {{ csrf_field() }}

                <div class="modal-header">
                    <h4 class="modal-title">Nuevo cliente</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection