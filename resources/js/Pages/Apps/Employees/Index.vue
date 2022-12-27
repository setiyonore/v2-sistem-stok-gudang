<template>
  <Head>
    <title>Pegawai - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-address-card"></i
                ></span>
                Pegawai
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <Link
                      href="/apps/employees/create"
                      v-if="hasAnyPermission(['pegawai.add'])"
                      class="btn btn-primary input-group-text"
                      ><i class="fa fa-plus-circle me-2"></i> Tambah
                    </Link>
                    <input
                      type="text"
                      v-model="search"
                      class="form-control"
                      placeholder="Cari Pegawai Berdasarkan nama..."
                    />

                    <button
                      class="btn btn-primary input-group-text"
                      type="submit"
                    >
                      <i class="fa fa-search me-2"></i> Cari
                    </button>
                  </div>
                </form>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">NIP</th>
                      <th scope="col">Jabatan</th>
                      <th scope="col">No Hp</th>
                      <th scope="col" style="width: 30%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data, index) in pegawai.data" :key="index">
                      <td>{{ data.nama }}</td>
                      <td>{{ data.nip }}</td>
                      <td>{{ data.jabatan }}</td>
                      <td>{{ data.no_hp }}</td>
                      <td class="text-center">
                        <Link
                          :href="`/apps/employees/${data.id}/edit`"
                          v-if="hasAnyPermission(['roles.edit'])"
                          class="btn btn-success btn-sm me-2"
                          ><i class="fa fa-pencil-alt me-1"></i> EDIT
                        </Link>
                        <Link
                          :href="`/apps/employees/${data.id}`"
                          v-if="hasAnyPermission(['roles.edit'])"
                          class="btn btn-primary btn-sm me-2"
                          ><i class="fas fa-eye"></i> DETIL
                        </Link>
                        <button
                          @click.prevent="destroy(data.id)"
                          v-if="hasAnyPermission(['roles.delete'])"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fa fa-trash"></i> DELETE
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="pegawai.links" align="end" />
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import Pagination from "../../../Components/Pagination.vue";
import Swal from "sweetalert2";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    pegawai: Object,
  },
  setup() {
    const search = ref("" || new URL(document.location).searchParams.get("q"));
    const handleSearch = () => {
      Inertia.get("/apps/employees", {
        q: search.value,
      });
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
          Inertia.delete(`/apps/employees/${id}`);
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
    return { search, handleSearch, destroy };
  },
};
</script>
