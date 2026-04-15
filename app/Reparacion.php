<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{

    protected $table = 'reparaciones';

    protected $fillable = [
'etiqueta',
'cliente_id',
'equipo',
'problema',
'encontrado',
'accesorios',
'estado',
'fecha_ingreso',
'fecha_salida',
'responsable'
];

}