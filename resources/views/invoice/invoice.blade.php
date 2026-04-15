@extends('include.master')

@section('title','Inventory | Facturación')

@section('page-title','Facturación')

@section('content')

<style>
    .invoice-card .body {
        padding: 22px;
    }
    .invoice-table thead th {
        background: #0d9a92;
        color: #fff;
        vertical-align: middle;
    }
    .invoice-table .form-control {
        min-width: 110px;
    }
    .invoice-total-box {
        margin-top: 18px;
        max-width: 420px;
    }
    .invoice-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card invoice-card">
            <div class="header">
                <h2>Crear factura</h2>
            </div>

            <div class="body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom:0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invoice.store') }}" method="POST" id="invoiceForm">
                    @csrf

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Seleccionar cliente</label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($customer as $item)
                                        <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número de factura</label>
                                <input type="text" class="form-control" value="{{ $invoice_no }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha de la factura</label>
                                <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered invoice-table" id="invoiceItemsTable">
                            <thead>
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>Categoría</th>
                                    <th>Producto</th>
                                    <th>Comprobante</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                    <th>Tipo desc.</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="invoiceItemsBody">
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-circle remove-row">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </td>
                                    <td>
                                        <select name="product[0][category]" class="form-control category-field" required>
                                            <option value="">Seleccione categoría</option>
                                            @foreach($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="product[0][product_id]" class="form-control product-id-field" placeholder="ID producto" required>
                                    </td>
                                    <td>
                                        <input type="number" name="product[0][chalan_id]" class="form-control chalan-field" placeholder="ID comprobante" required>
                                    </td>
                                    <td>
                                        <input type="number" name="product[0][quantity]" class="form-control qty-field" value="1" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="product[0][price]" class="form-control price-field" value="0" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="product[0][discount]" class="form-control discount-field" value="0">
                                    </td>
                                    <td>
                                        <select name="product[0][discount_type]" class="form-control discount-type-field">
                                            <option value="amount">Importe</option>
                                            <option value="percent">Porcentaje</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="product[0][total_price]" class="form-control line-total-field" value="0" readonly>
                                        <input type="hidden" name="product[0][discount_amount]" class="discount-amount-field" value="0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="invoice-actions">
                        <button type="button" class="btn bg-teal waves-effect" id="addInvoiceRow">
                            + Añadir más
                        </button>
                    </div>

                    <div class="invoice-total-box">
                        <div class="form-group">
                            <label>Total descuento</label>
                            <input type="number" step="0.01" name="total_discount" id="total_discount" class="form-control" value="0" readonly>
                        </div>
                        <div class="form-group">
                            <label>Total general</label>
                            <input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control" value="0" readonly>
                        </div>
                        <div class="form-group">
                            <label>Monto pagado</label>
                            <input type="number" step="0.01" name="paid_amount" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label>Método de pago</label>
                            <select name="payment_info" class="form-control">
                                <option value="cash">Efectivo</option>
                                <option value="bank">Banco</option>
                            </select>
                        </div>
                        <input type="hidden" name="payment_in" value="Caja">
                        <input type="hidden" name="bank_info" value="">
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn bg-teal waves-effect">
                            Guardar factura
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('invoiceItemsBody');
    const addBtn = document.getElementById('addInvoiceRow');

    function calculateRow(row) {
        const qty = parseFloat(row.querySelector('.qty-field').value) || 0;
        const price = parseFloat(row.querySelector('.price-field').value) || 0;
        const discount = parseFloat(row.querySelector('.discount-field').value) || 0;
        const discountType = row.querySelector('.discount-type-field').value;
        const lineTotalField = row.querySelector('.line-total-field');
        const discountAmountField = row.querySelector('.discount-amount-field');

        let subtotal = qty * price;
        let discountAmount = 0;

        if (discountType === 'percent') {
            discountAmount = (subtotal * discount) / 100;
        } else {
            discountAmount = discount;
        }

        let total = subtotal - discountAmount;
        if (total < 0) total = 0;

        lineTotalField.value = total.toFixed(2);
        discountAmountField.value = discountAmount.toFixed(2);

        calculateTotals();
    }

    function calculateTotals() {
        let grandTotal = 0;
        let totalDiscount = 0;

        document.querySelectorAll('#invoiceItemsBody tr').forEach(row => {
            grandTotal += parseFloat(row.querySelector('.line-total-field').value) || 0;
            totalDiscount += parseFloat(row.querySelector('.discount-amount-field').value) || 0;
        });

        document.getElementById('grand_total').value = grandTotal.toFixed(2);
        document.getElementById('total_discount').value = totalDiscount.toFixed(2);
    }

    function bindRowEvents(row) {
        row.querySelectorAll('.qty-field, .price-field, .discount-field, .discount-type-field').forEach(el => {
            el.addEventListener('input', function () {
                calculateRow(row);
            });
            el.addEventListener('change', function () {
                calculateRow(row);
            });
        });

        row.querySelector('.remove-row').addEventListener('click', function () {
            if (tbody.querySelectorAll('tr').length > 1) {
                row.remove();
                reindexRows();
                calculateTotals();
            }
        });
    }

    function reindexRows() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            row.querySelectorAll('input, select').forEach(field => {
                const name = field.getAttribute('name');
                if (name) {
                    field.setAttribute('name', name.replace(/product\[\d+\]/, 'product[' + index + ']'));
                }
            });
        });
    }

    addBtn.addEventListener('click', function () {
        const firstRow = tbody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => {
            if (input.classList.contains('qty-field')) input.value = 1;
            else if (input.classList.contains('price-field')) input.value = 0;
            else if (input.classList.contains('discount-field')) input.value = 0;
            else if (input.classList.contains('line-total-field')) input.value = 0;
            else if (input.classList.contains('discount-amount-field')) input.value = 0;
            else input.value = '';
        });
        newRow.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });
        tbody.appendChild(newRow);
        reindexRows();
        bindRowEvents(newRow);
    });

    document.querySelectorAll('#invoiceItemsBody tr').forEach(bindRowEvents);
    calculateTotals();
});
</script>

@endsection