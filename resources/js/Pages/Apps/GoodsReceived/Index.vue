<template>
  <Head>
    <title>Barang Masuk - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <span class="font-weight-bold"
                      ><i class="fas fa-box-open"></i> Barang Masuk</span
                    >
                  </div>
                  <div class="col-6 text-right">
                    <button
                      class="btn btn-primary input-group-text ml-1"
                      @click="cetak"
                    >
                      <i class="fa fa-file-pdf"></i> Export
                    </button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <Link
                      href="/apps/received_goods/create"
                      v-if="hasAnyPermission(['barang_masuk.add'])"
                      class="btn btn-primary input-group-text mr-1"
                      ><i class="fa fa-plus-circle me-2"></i> Tambah
                    </Link>
                    <label for="" class="font-weight-bold input-group-text"
                      >Tanggal Awal</label
                    >
                    <input
                      type="date"
                      v-model="dateStart"
                      class="form-control"
                      :placeholder="getDateStr"
                    />
                    <label for="" class="font-weight-bold input-group-text ml-1"
                      >Tanggal Akhir</label
                    >
                    <input
                      type="date"
                      v-model="dateEnd"
                      class="form-control"
                      :placeholder="getDateStr"
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
                      <th scope="col">Tanggal</th>
                      <th scope="col">Yang Menyerahkan</th>
                      <th scope="col">Pegawai</th>
                      <th scope="col">Keterangan</th>
                      <th scope="col" style="width: 30%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data, index) in barang_masuk.data" :key="index">
                      <td>{{ data.tanggal }}</td>
                      <td>{{ data.yang_menyerahkan }}</td>
                      <td>{{ data.pegawai }}</td>
                      <td>{{ data.keterangan }}</td>
                      <td class="text-center">
                        <Link
                          :href="`/apps/received_goods/${data.id}/edit`"
                          v-if="hasAnyPermission(['barang_masuk.edit'])"
                          class="btn btn-success btn-sm me-2"
                          ><i class="fa fa-pencil-alt me-1"></i> EDIT
                        </Link>
                        <Link
                          :href="`/apps/received_goods/${data.id}`"
                          v-if="hasAnyPermission(['barang_masuk.edit'])"
                          class="btn btn-primary btn-sm me-2"
                          ><i class="fas fa-eye"></i> DETIL
                        </Link>
                        <button
                          @click.prevent="destroy(data.id)"
                          v-if="hasAnyPermission(['barang_masuk.delete'])"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fa fa-trash"></i> DELETE
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="barang_masuk.links" align="end" />
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
import Pagination from "../../../Components/Pagination.vue";
import Swal from "sweetalert2";
import { ref } from "vue";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    barang_masuk: Array,
  },
  methods: {
    cetak() {
      alert("export");
    },
  },
  setup() {
    const dateStart = ref(
      "" || new URL(document.location).searchParams.get("datestart")
    );
    const dateEnd = ref(
      "" || new URL(document.location).searchParams.get("dateend")
    );
    const handleSearch = () => {
      Inertia.get("/apps/received_goods", {
        datestart: dateStart.value,
        dateend: dateEnd.value,
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
          Inertia.delete(`/apps/received_goods/${id}`);
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
    return { dateStart, dateEnd, handleSearch, destroy };
  },
};
</script>
