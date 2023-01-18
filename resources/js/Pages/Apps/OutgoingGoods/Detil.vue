<template>
  <Head>
    <title>Detil Barang Keluar - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-box"></i> Detil Barang Keluar</span
                >
              </div>
              <div class="card-body">
                <hr />
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <b>No SP:</b> {{ barang_keluar.no_sp }}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3"><b>Tanggal:</b> {{ formattedDate }}</div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <b>Status:</b> {{ barang_keluar.status }}
                    </div>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <b>Pelanggan:</b> {{ barang_keluar.pelanggan }}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <b>Yang Meminta:</b> {{ barang_keluar.pegawai }}
                    </div>
                  </div>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr style="background-color: #e6e6e7">
                      <th scope="col">No</th>
                      <th scope="col">Barang</th>
                      <th scope="col">Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="item.barang">
                      <td>{{ index + 1 }}</td>
                      <td>{{ item.barang }}</td>
                      <td>{{ item.jumlah }}</td>
                    </tr>
                  </tbody>
                </table>
                <div
                  class="row"
                  v-if="hasAnyPermission(['barang_keluar.approval'])"
                >
                  <div class="col-6" v-if="barang_keluar.status_sp == 11">
                    <button
                      class="btn btn-success shadow-sm rounded-sm"
                      type="submit"
                      @click="approve"
                    >
                      Setujui
                    </button>
                    <button
                      class="btn btn-warning shadow-sm rounded-sm ms-3"
                      type="reset"
                      @click="notApprove"
                    >
                      Tolak
                    </button>
                  </div>
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import moment from "moment";
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    barang_keluar: Object,
    items: Array,
  },
  methods: {
    approve() {
      Swal.fire({
        title: "Konfirmasi !!!",
        text: "Anda Menyetujui Barang Keluar ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6469EB",
        cancelButtonColor: "#d33",
        confirmButtonText: "Setujui",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.post(
            "/apps/barang_keluar/approve",
            {
              id: this.barang_keluar.sp_id,
            },
            {
              onSuccess: () => {
                Swal.fire({
                  title: "Success !",
                  text: "Data Berhasil Disimpan",
                  icon: "success",
                  showConfirmButton: false,
                  timer: 2000,
                });
              },
            }
          );
        }
      });
    },
    notApprove() {
      alert("not approve");
    },
  },
  computed: {
    formattedDate() {
      return moment(this.barang_keluar.tanggal).format("DD/MM/YYYY");
    },
  },
};
</script>
