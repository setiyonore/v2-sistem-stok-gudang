<template>
  <Head>
    <title>Tambah Barang Masuk - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-box-open"></i> Tambah Barang Masuk</span
                >
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="tanggal" class="font-weight-bold">
                        Tanggal
                      </label>
                      <input
                        type="date"
                        class="form-control"
                        v-model="form.tanggal"
                        :class="{ 'is-invalid': errors.tanggal }"
                      />
                    </div>
                    <div v-if="errors.tanggal" class="alert alert-danger">
                      {{ errors.tanggal }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="tanggal" class="font-weight-bold">
                        Yang Menyerahkan
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        v-model="form.yang_menyerahkan"
                        :class="{ 'is-invalid': errors.yang_menyerahkan }"
                      />
                    </div>
                    <div
                      v-if="errors.yang_menyerahkan"
                      class="alert alert-danger"
                    >
                      {{ errors.yang_menyerahkan }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="tanggal" class="font-weight-bold">
                        Keterangan
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        v-model="form.keterangan"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="penyedia" class="font-weight-bold"
                        >Penyedia</label
                      >
                      <select
                        class="form-select"
                        aria-label="Default select example"
                        v-model="form.penyedia"
                      >
                        <option value="">Pilih Penyedia</option>
                        <option
                          v-for="(data, index) in penyedia"
                          :key="index"
                          :value="data.id"
                        >
                          {{ data.nama }}
                        </option>
                      </select>
                    </div>
                    <div v-if="errors.penyedia" class="alert alert-danger">
                      {{ errors.penyedia }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="barang" class="font-weight-bold"
                        >Barang</label
                      >
                      <Select2
                        v-model="form.barang"
                        :options="barang"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label for="jumlah" class="font-weight-bold"
                        >Jumlah</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        v-model="form.jumlah"
                      />
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label fw-bold text-white">*</label>
                      <button
                        class="btn btn-md btn-success border-0 shadow w-100"
                        @click="addBarang"
                      >
                        <i class="fa fa-plus"></i> Tambah Barang
                      </button>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr style="background-color: #e6e6e7">
                      <th scope="col">#</th>
                      <th scope="col">Barang</th>
                      <th scope="col">Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="item.barang_id">
                      <td class="text-center">
                        <button
                          class="btn btn-danger btn-sm rounded-pill"
                          @click="deleteBarang(index)"
                        >
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                      <td>
                        <Select2
                          v-model="item.barang_id"
                          :options="barang"
                          :settings="{ width: '100%' }"
                        />
                      </td>
                      <td><input type="number" v-model="item.jumlah" /></td>
                    </tr>
                  </tbody>
                </table>
                <div v-if="errors.barang" class="alert alert-danger">
                  {{ errors.barang }}
                </div>
                <div class="row">
                  <div class="col-12">
                    <button
                      class="btn btn-primary shadow-sm rounded-sm"
                      type="submit"
                      @click="submit"
                    >
                      Simpan
                    </button>
                    <button
                      class="btn btn-warning shadow-sm rounded-sm ms-3"
                      type="reset"
                      @click="reset"
                    >
                      Reset
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
import { reactive } from "vue";
import Select2 from "vue3-select2-component";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Select2,
  },
  data() {
    return {
      items: [],
    };
  },
  props: {
    errors: Object,
    penyedia: Array,
    barang: Array,
  },
  methods: {
    addBarang() {
      axios
        .post(`/apps/barang_masuk/searchGood`, {
          id_barang: this.form.barang,
        })
        .then((response) => {
          this.items.push({
            barang_id: this.form.barang,
            jumlah: this.form.jumlah,
            nama: response.data.nama,
          });
          this.form.barang = "";
          this.form.jumlah = "";
        });
    },
    deleteBarang(index) {
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
          this.items.splice(index, 1);
        }
      });
    },
    submit() {
      Inertia.post(
        "/apps/received_goods",
        {
          tanggal: this.form.tanggal,
          yang_menyerahkan: this.form.yang_menyerahkan,
          keterangan: this.form.keterangan,
          penyedia: this.form.penyedia,
          barang: this.items,
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
    },
    reset() {
      this.form.tanggal = "";
      this.form.yang_menyerahkan = "";
      this.form.keterangan = "";
      this.form.penyedia = "";
      this.items = "";
    },
  },
  setup() {
    const form = reactive({
      tanggal: "",
      yang_menyerahkan: "",
      keterangan: "",
      penyedia: "",
      barang: "",
      jumlah: "",
    });
    return { form };
  },
};
</script>
