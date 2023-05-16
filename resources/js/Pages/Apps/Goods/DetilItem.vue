<template>
  <head>
    <title>Detil Item Barang - Sistem Informasi Stok Gudang</title>
  </head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="row">
            <div class="col-md-12">
              <div class="card border-0 rounded-3 shadow border-top-purple">
                <div class="card-header">
                  <span class="font-weight-bold"
                    ><i class="fas fa-boxes"></i> Detil Item
                    {{ barang.nama }}</span
                  >
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="input-group mb-3">
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Cari berdasarkan no serial ..."
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
                      <th scope="col">No</th>
                      <th scope="col">Nomor Serial</th>
                      <th scope="col">Status</th>
                      <th scope="col">Kondisi</th>
                      <th scope="col" style="width: 30%">Action</th>
                    </thead>
                    <tbody>
                      <tr v-for="(data, index) in item.data" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ data.no_serial }}</td>
                        <td>{{ data.status }}</td>
                        <td>{{ data.kondisi }}</td>
                        <td class="text-center">
                          <button
                            class="btn btn-primary btn-sm me-2"
                            data-toggle="modal"
                            data-target="#exampleModal"
                            @click="getItem(data.id, data.no_serial)"
                          >
                            <i class="fas fa-history"></i> History Item
                          </button>
                          <Link
                            v-if="hasAnyPermission(['barang.edit'])"
                            class="btn btn-success btn-sm me-2"
                            ><i class="fa fa-pencil-alt me-1"></i> EDIT
                          </Link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :links="item.links" align="end"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ barang.nama }} (No Serial: {{ noSerial }})
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="text-center" v-if="loadingShow">
              <h1><i class="fas fa-spinner fa-spin fa-lg"></i></h1>
            </div>
            <table class="table table-bordered" v-if="tableShow">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Jenis Transaksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in history" :key="item.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.tanggal }}</td>
                  <td>{{ item.status }}</td>
                  <td>{{ item.jenis_transaksi }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
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
import axios, { Axios } from "axios";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    barang: Object,
    item: Object,
  },
  data() {
    return {
      tableShow: false,
      loadingShow: true,
      noSerial: "",
      history: [],
    };
  },
  methods: {
    getItem(id, serial) {
      axios.get(`/apps/barang/historyItem/${id}`).then((response) => {
        this.noSerial = serial;
        this.history = response.data.history;
        this.tableShow = true;
        this.loadingShow = false;
      });
    },
  },
  setup() {},
};
</script>
