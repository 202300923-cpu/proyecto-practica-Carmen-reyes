@extends('include.master')

@section('title','Inventory | Dashboard')
@section('page-title','¡Bienvenido, INNOVATEC!')

@section('content')

<div class="row clearfix">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">assignment_ind</i>
            </div>
            <div class="content">
                <div class="text">Clientes</div>
                <div class="number">{{ $total_customer }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">group</i>
            </div>
            <div class="content">
                <div class="text">Proveedores</div>
                <div class="number">{{ $total_vendor }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-deep-purple hover-expand-effect">
            <div class="icon">
                <i class="material-icons">category</i>
            </div>
            <div class="content">
                <div class="text">Gestión de Accesorios</div>
                <div class="number">{{ $total_accesorios }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey hover-expand-effect">
            <div class="icon">
                <i class="material-icons">receipt</i>
            </div>
            <div class="content">
                <div class="text">Facturas</div>
                <div class="number">{{ $total_invoice }}</div>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-indigo hover-expand-effect">
            <div class="icon">
                <i class="material-icons">local_offer</i>
            </div>
            <div class="content">
                <div class="text">Etiquetas total</div>
                <div class="number">{{ $total_quantity }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">local_shipping</i>
            </div>
            <div class="content">
                <div class="text">Accesorios vendidos</div>
                <div class="number">{{ $total_sold_quantity }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue hover-expand-effect">
            <div class="icon">
                <i class="material-icons">equalizer</i>
            </div>
            <div class="content">
                <div class="text">Etiquetas actual</div>
                <div class="number">{{ $total_current_quantity }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red hover-expand-effect">
            <div class="icon">
                <i class="material-icons">inbox</i>
            </div>
            <div class="content">
                <div class="text">Accesorios en Stock</div>
                <div class="number">{{ $total_current_quantity }}</div>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="content">
                <div class="text">Importe pagado</div>
                <div class="number">$ {{ round($total_paid_amount) }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red hover-expand-effect">
            <div class="icon">
                <i class="material-icons">money_off</i>
            </div>
            <div class="content">
                <div class="text">Importe restante</div>
                <div class="number">$ {{ round($total_outstanding) }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-brown hover-expand-effect">
            <div class="icon">
                <i class="material-icons">account_balance_wallet</i>
            </div>
            <div class="content">
                <div class="text">Beneficio bruto</div>
                <div class="number">$ {{ round($total_gross_profit) }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-blue hover-expand-effect">
            <div class="icon">
                <i class="material-icons">credit_card</i>
            </div>
            <div class="content">
                <div class="text">Beneficio neto</div>
                <div class="number">$ {{ round($total_net_profit) }}</div>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-purple hover-expand-effect">
            <div class="icon">
                <i class="material-icons">build</i>
            </div>
            <div class="content">
                <div class="text">Reparaciones</div>
                <div class="number">{{ $total_reparaciones }}</div>
            </div>
        </div>
    </div>

</div>

@endsection