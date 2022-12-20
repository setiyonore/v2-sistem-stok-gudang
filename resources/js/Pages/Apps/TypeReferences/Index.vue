<template>
  <Head>
    <title>Jenis Referensi - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="col-md-12">
          <div class="card border-0 shadow rounded-3 border-top-purple">
            <div class="card-header">
              <span class="font-weight-bold"
                ><i class="fas fa-list"></i> Jenis Referensi</span
              >
            </div>
            <div class="card-body">
              <form>
                <div class="input-group mb-3">
                  <Link
                    href="/apps/type_references/create"
                    v-if="hasAnyPermission(['jenis_referensi.add'])"
                    class="btn btn-primary input-group-text"
                    ><i class="fa fa-plus-circle me-2"></i> Tambah
                  </Link>
                  <input
                    type="text"
                    v-model="search"
                    class="form-control"
                    placeholder="Cari Jenis Referensi ..."
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
                    <th scope="col">Deskripsi</th>
                    <th scope="col" style="width: 20%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(data, index) in jenis_referensi.data"
                    :key="index"
                  >
                    <td>{{ data.nama }}</td>
                    <td>{{ data.deskripsi }}</td>
                    <td class="text-center">
                      <Link
                        :href="`/apps/type_references/${data.id}/edit`"
                        v-if="hasAnyPermission(['jenis_referensi.edit'])"
                        class="btn btn-success btn-sm me-2"
                        ><i class="fa fa-pencil-alt me-1"></i> Edit</Link
                      >
                      <button
                        @click.prevent="destroy(data.id)"
                        v-if="hasAnyPermission(['jenis_referensi.delete'])"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="fa fa-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <Pagination :links="jenis_referensi.links" align="end" />
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
import Pagination from "../../../Components/Pagination.vue";
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
    jenis_referensi: Object,
  },
  setup() {
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
          Inertia.delete(`/apps/type_references/${id}`);
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
    return { destroy };
  },
};
</script>
