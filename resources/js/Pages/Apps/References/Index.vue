<template>
  <Head>
    <title>Referensi - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-list-ul"></i
                ></span>
                Referensi
              </div>
              <div class="card-body">
                <form @submit.prevent="filter">
                  <div class="row">
                    <div class="col-md-10">
                      <div class="mb-3">
                        <label for="jenis" class="font-weight-bold"
                          >Jenis Referensi</label
                        >
                        <select
                          class="form-select"
                          aria-label="Default select example"
                          v-model="form.jenis_referensi"
                        >
                          <option
                            v-for="(data, index) in jenis_referensi"
                            :key="index"
                            :value="data.id"
                            :selected="
                              form.jenis_referensi == id_jenis_referensi
                            "
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="mb-3">
                        <label class="form-label fw-bold text-white">*</label>
                        <button
                          class="btn btn-md btn-purple border-0 shadow w-100"
                        >
                          <i class="fa fa-filter"></i> FILTER
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
                <div v-if="referensi">
                  <div class="mb-3">
                    <button
                      @click.prevent="create"
                      class="btn btn-primary input-group-text"
                      v-if="hasAnyPermission(['referensi.add'])"
                    >
                      <i class="fa fa-plus-circle me-2"></i> Tambah
                    </button>
                  </div>
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col" style="width: 30%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data, index) in referensi.data" :key="index">
                        <td>{{ data.nama }}</td>
                        <td>{{ data.deskripsi }}</td>
                        <td class="text-center">
                          <Link
                            :href="`/apps/references/${data.id}/edit`"
                            v-if="hasAnyPermission(['referensi.edit'])"
                            class="btn btn-success btn-sm me-2"
                            ><i class="fa fa-pencil-alt me-1"></i> EDIT
                          </Link>
                          <!-- <button
                            @click.prevent="destroy(data.id)"
                            v-if="hasAnyPermission(['referensi.delete'])"
                            class="btn btn-danger btn-sm"
                          >
                            <i class="fa fa-trash"></i> DELETE
                          </button> -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :links="referensi.links" align="end" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
import LayoutApp from "../../../Layouts/App.vue";
import Pagination from "../../../Components/Pagination.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    id_jenis_referensi: "",
    jenis_referensi: Array,
    referensi: Array,
  },
  setup() {
    const form = reactive({
      jenis_referensi: "",
    });
    const filter = () => {
      Inertia.get("/apps/referensi/filter", {
        jenis_referensi: form.jenis_referensi,
      });
      localStorage.setItem("id_filter", form.jenis_referensi);
    };
    const create = () => {
      Inertia.get("/apps/references/create");
    };
    const destroy = (id) => {
      Swal.fire({
        title: "Konfirmasi !!!",
        text: "Anda Akan Menghapus Data ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(`/apps/references/${id}`);
          Swal.fire({
            title: "Sukses",
            text: "Data Berhasil Di Hapus",
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          });
        }
      });
    };
    return { form, filter, create, destroy };
  },
  beforeMount() {
    const id_filter = localStorage.getItem("id_filter");
    if (id_filter != null) {
      this.form.jenis_referensi = localStorage.getItem("id_filter");
    } else {
      this.form.jenis_referensi = 1;
      localStorage.setItem("id_filter", 1);
    }
  },
};
</script>
