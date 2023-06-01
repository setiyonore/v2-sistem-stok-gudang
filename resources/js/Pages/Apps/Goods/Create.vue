<template>
  <Head>
    <title>Tambah Barang - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-list"></i
                ></span>
                Tambah Barang
              </div>
              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="nama" class="font-weight-bold">Nama</label>
                        <input
                          type="text"
                          class="form-control"
                          :class="{ 'is-invalid': errors.nama }"
                          v-model="form.nama"
                        />
                      </div>
                      <div v-if="errors.nama" class="alert alert-danger">
                        {{ errors.nama }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="satuan" class="font-weigt-bold"
                          >Satuan</label
                        >
                        <select class="form-select" v-model="form.satuan">
                          <option value="">Pilih Satuan</option>
                          <option
                            v-for="(data, index) in satuan"
                            :key="index"
                            :value="data.id"
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                      <div v-if="errors.satuan" class="alert alert-danger">
                        {{ errors.satuan }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="kategori" class="font-weight-bold"
                          >Kategori</label
                        >
                        <select class="form-select" v-model="form.kategori">
                          <option value="">Pilih kategori</option>
                          <option
                            v-for="(data, index) in kategori"
                            :key="index"
                            :value="data.id"
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                      <div v-if="errors.kategori" class="alert alert-danger">
                        {{ errors.kategori }}
                      </div>
                    </div>
<!--                    <div-->
<!--                      class="col-md-6"-->
<!--                      v-if="hasAnyPermission(['barang.field_stok'])"-->
<!--                    >-->
<!--                      <div class="mb-3">-->
<!--                        <label for="stok" class="font-weight-bold">Stok</label>-->
<!--                        <input-->
<!--                          type="text"-->
<!--                          class="form-control"-->
<!--                          v-model="form.stok"-->
<!--                        />-->
<!--                      </div>-->
<!--                    </div>-->
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button
                        class="btn btn-primary shadow-sm rounded-sm"
                        type="submit"
                      >
                        Simpan
                      </button>
                      <button
                        class="btn btn-warning shadow-sm rounded-sm ms-3"
                        type="reset"
                      >
                        Reset
                      </button>
                    </div>
                  </div>
                </form>
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
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    errors: Object,
    satuan: Array,
    kategori: Array,
  },
  setup() {
    const form = reactive({
      nama: "",
      satuan: "",
      kategori: "",
      stok: "",
    });
    const submit = () => {
      Inertia.post(
        "/apps/goods",
        {
          nama: form.nama,
          satuan: form.satuan,
          kategori: form.kategori,
          stok: form.stok,
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
    };
    return { form, submit };
  },
};
</script>
