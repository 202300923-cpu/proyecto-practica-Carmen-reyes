<template>

<div class="body table-responsive">

<table class="table table-bordered">

<thead>

    <td>

<select class="form-control" v-model="r.estado" @change="cambiarEstado(r)">

<option value="pendiente">Pendiente</option>
<option value="proceso">En proceso</option>
<option value="terminado">Terminado</option>

</select>

<td>

<select class="form-control" v-model="r.estado" @change="cambiarEstado(r)">

<option value="pendiente">Pendiente</option>
<option value="proceso">En proceso</option>
<option value="terminado">Terminado</option>

</select>

</td>

</td>

<tr>
<th>Etiqueta</th>
<th>Equipo</th>
<th>Problema</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

</thead>

<tbody>

<tr v-for="r in reparaciones" :key="r.id">

<td>{{ r.etiqueta }}</td>
<td>{{ r.equipo }}</td>
<td>{{ r.problema }}</td>
<td>{{ r.estado }}</td>

<td>

<td>

<button 
class="btn btn-info btn-circle waves-effect waves-circle waves-float"
@click="editar(r)">

<i class="material-icons">edit</i>

</button>

<button 
class="btn btn-danger btn-circle waves-effect waves-circle waves-float"
@click="eliminar(r.id)">

<i class="material-icons">delete</i>

</button>

</td>

</td>

</tr>

</tbody>

</table>

</div>

</template>

<script>

export default {

props: ['reparaciones'],

methods:{

eliminar(id){

axios.delete('/reparaciones/delete/'+id)

.then(response=>{
location.reload();
})

},

editar(r){

console.log(r)

}

}

}


</script>
