<template>
  <Head>
    <title>Dashboard - Sistem Informasi Stok Gudang</title>
  </Head>

  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fa fa-chart-bar"></i> Chart Barang Keluar Masuk 7
                  Hari</span
                >
              </div>
              <div class="card-body"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow border-top-warning">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-mail-bulk"></i> Surat Permintaan
                  Pending</span
                >
              </div>
              <div class="card-body">
                <div class="row" v-for="(data, index) in order" :key="index">
                  <div class="col-8">
                    <a
                      :href="`/apps/order/${data.id}`"
                      style="text-decoration: none; color: black"
                    >
                      <b>{{ data.no_sp }}</b>
                    </a>
                  </div>
                  <div class="col-4 text-right text-danger">
                    {{ data.tanggal }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow border-top-danger">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fa fa-box-open"></i> Stok Barang Dibawah 10</span
                >
              </div>
              <div class="card-body">
                <div v-if="stok.length > 0">
                  <ol class="list-group list-group-numbered">
                    <li
                      v-for="product in stok"
                      :key="product.id"
                      class="
                        list-group-item
                        d-flex
                        justify-content-between
                        align-items-start
                      "
                    >
                      <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ product.nama }}</div>
                        <!-- <div class="text-muted">Category : {{ product.category.name }}</div> -->
                      </div>
                      <span class="badge bg-danger rounded-pill">{{
                        product.stok
                      }}</span>
                    </li>
                  </ol>
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
//import layout
import LayoutApp from "../../../Layouts/App.vue";

//import Head and useForm from Inertia
import { Head } from "@inertiajs/inertia-vue3";

export default {
  //layout
  layout: LayoutApp,

  //register component
  components: {
    Head,
  },
  props: {
    stok: Array,
    order: Array,
  },
};
</script>

<style>
</style>
