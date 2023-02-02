<template>
  <Head>
    <title>Dashboard - Sistem Informasi Stok Gudang</title>
  </Head>

  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fa fa-chart-bar"></i> Chart Barang Masuk 7
                  Hari</span
                >
              </div>
              <div class="card-body">
                <BarChart
                  :chartData="chartBarangMasukWeek"
                  :options="options"
                />
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow border-top-success">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fa fa-chart-bar"></i> Chart Barang Keluar 7
                  Hari</span
                >
              </div>
              <div class="card-body">
                <BarChart
                  :chartData="chartBarangKeluarWeek"
                  :options="options"
                />
              </div>
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
import { ref } from "vue";
//import Head and useForm from Inertia
import { Head } from "@inertiajs/inertia-vue3";
//chart
import { BarChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";

//register chart
Chart.register(...registerables);
export default {
  //layout
  layout: LayoutApp,

  //register component
  components: {
    Head,
    BarChart,
  },
  props: {
    stok: Array,
    order: Array,
    date_barang_masuk: Array,
    total_barang_masuk: Array,
    date_barang_keluar: Array,
    total_barang_keluar: Array,
  },
  setup(props) {
    //method random color
    function randomBackgroundColor(length) {
      var data = [];
      for (var i = 0; i < length; i++) {
        data.push(getRandomColor());
      }
      return data;
    }

    //method generate random color
    function getRandomColor() {
      var letters = "0123456789ABCDEF".split("");
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    //option chart
    const options = ref({
      responsive: true,
      plugins: {
        legend: {
          display: false,
        },
        title: {
          display: false,
        },
      },
      beginZero: true,
    });
    //chart barang masuk week
    const chartBarangMasukWeek = {
      labels: props.date_barang_masuk,
      datasets: [
        {
          data: props.total_barang_masuk,
          backgroundColor: randomBackgroundColor(
            props.date_barang_masuk.length
          ),
        },
      ],
    };
    //chart barang masuk week
    const chartBarangKeluarWeek = {
      labels: props.date_barang_keluar,
      datasets: [
        {
          data: props.total_barang_keluar,
          backgroundColor: randomBackgroundColor(
            props.date_barang_keluar.length
          ),
        },
      ],
    };
    return { options, chartBarangMasukWeek, chartBarangKeluarWeek };
  },
};
</script>

<style>
</style>
