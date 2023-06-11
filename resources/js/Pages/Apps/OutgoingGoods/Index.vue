<template>
  <Head>
    <title>Barang Keluar - Sistem Informasi Stok Gudang</title>
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
                      ><i class="fas fa-box"></i> Barang Keluar</span
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
                      <th scope="col">Pelanggan</th>
                      <th scope="col">No Sp</th>
                      <th scope="col">Status</th>
                      <th scope="col" style="width: 30%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(data, index) in barang_keluar.data"
                      :key="index"
                    >
                      <td>{{ data.tanggal }}</td>
                      <td>{{ data.pelanggan }}</td>
                      <td>{{ data.no_sp }}</td>
                      <td>{{ data.status }}</td>
                      <td class="text-center">
                        <Link
                          :href="`/apps/outgoing_goods/${data.id}`"
                          v-if="hasAnyPermission(['barang_keluar.index'])"
                          class="btn btn-primary btn-sm me-2"
                          ><i class="fas fa-eye"></i> DETIL
                        </Link>
                        <button
                          @click="print(data.id)"
                          class="btn btn-info btn-sm"
                        >
                          <i class="fa fa-print"></i> PRINT
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="barang_keluar.links" align="end" />
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
import Pagination from "../../../Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import moment from "moment";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    barang_keluar: Array,
  },
  methods: {
    print(id) {
      window.open(`/apps/permintaan/print?id=${id}`, "_blank");
    },
    //untuk cetak rekap barang keluar
    cetak() {
      let dateAwal = this.dateStart;
      let dateAkhir = this.dateEnd;
      if (dateAwal == null && dateAkhir == null) {
        let date = new Date(),
          y = date.getFullYear(),
          m = date.getMonth();
        let fisrtDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        let finalFirstDay = moment(fisrtDay).format("yyyy/MM/DD");
        let finalLastDay = moment(lastDay).format("yyyy/MM/DD");
        window.open(
          `/apps/barang_keluar/recap/${finalFirstDay + "/" + finalLastDay}`,
          "_blank"
        );
      } else {
        let date =
          dateAwal.replaceAll("-", "/") + "/" + dateAkhir.replaceAll("-", "/");
        window.open(`/apps/barang_keluar/recap/${date}`, "_blank");
      }
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
      Inertia.get("/apps/outgoing_goods", {
        datestart: dateStart.value,
        dateend: dateEnd.value,
      });
    };
    return { dateStart, dateEnd, handleSearch };
  },
};
</script>
