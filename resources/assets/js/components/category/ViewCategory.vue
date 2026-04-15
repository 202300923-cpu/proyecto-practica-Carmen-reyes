<template>
  <div class="wrap">
    <div class="body">
      <div class="row">
        <div class="col-md-12">
          <input
            type="text"
            class="form-control"
            @keyup="getData"
            placeholder="Buscar por nombre"
            v-model="name"
          />
        </div>
      </div>

      <br />

      <div class="row" v-if="isLoading">
        <div class="col-md-12">
          <h4 style="text-align:center;">Cargando...</h4>
        </div>
      </div>

      <div class="table-responsive" v-else>
        <table
          class="table table-condensed table-hover"
          v-if="categorys.data && categorys.data.length > 0"
        >
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="value in categorys.data" :key="value.id">
              <td>{{ value.name }}</td>

              <td>
                <button
                  type="button"
                  class="btn bg-blue btn-circle waves-effect waves-circle waves-float"
                  @click="editCategory(value.id)"
                >
                  <i class="material-icons">edit</i>
                </button>
              </td>

              <td>
                <button
                  type="button"
                  class="btn bg-pink btn-circle waves-effect waves-circle waves-float"
                  @click="deleteCategory(value.id)"
                >
                  <i class="material-icons">delete</i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-else class="alert alert-info">
          No hay categorías registradas.
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";

export default {
  mixins: [mixin],

  data() {
    return {
      categorys: {
        data: []
      },
      name: "",
      isLoading: false
    };
  },

  created() {
    this.getData();

    EventBus.$on("category-created", () => {
      this.getData();
    });
  },

  methods: {
    getData(page = 1) {
      this.isLoading = true;

      axios
        .get(base_url + "category-list", {
          params: {
            page: page,
            name: this.name
          }
        })
        .then((response) => {
          this.categorys = response.data;
          this.isLoading = false;
        })
        .catch((error) => {
          console.log(error);
          this.isLoading = false;
        });
    },

    editCategory(id) {
      alert("La edición la conectamos después. ID: " + id);
    },

    deleteCategory(id) {
      if (!confirm("¿Eliminar esta categoría?")) {
        return;
      }

      axios
        .get(base_url + "category/delete/" + id)
        .then((res) => {
          this.getData();
          if (this.successALert) {
            this.successALert(res.data);
          } else {
            alert(res.data);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    }
  }
};
</script>