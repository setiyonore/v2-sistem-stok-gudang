<template>
  <Head>
    <title>Tambah Referensi - Sistem Informasi Stok Gudang</title>
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
                Tambah Referensi
              </div>
              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="jenis" class="font-weight-bold"
                          >Jenis Referensi</label
                        >
                        <select
                          class="form-select"
                          aria-label="Default select example"
                          v-model="form.jenis_referensi_id"
                        >
                          <option
                            v-for="(data, index) in jenis_referensi"
                            :key="index"
                            :value="data.id"
                            :selected="form.jenis_referensi_id"
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                    </div>
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
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="deskripsi" class="font-weight-bold"
                          >Deskripsi</label
                        >
                        <input
                          class="form-control"
                          type="text"
                          :class="{ 'is-invalid': errors.deskripsi }"
                          v-model="form.deskripsi"
                        />
                      </div>
                      <div v-if="errors.deskripsi" class="alert alert-danger">
                        {{ errors.deskripsi }}
                      </div>
                    </div>
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
    jenis_referensi: Array,
    errors: Object,
  },
  setup() {
    const form = reactive({
      jenis_referensi_id: "",
      nama: "",
      deskripsi: "",
    });
    const submit = () => {
      Inertia.post(
        "/apps/references",
        {
          jenis_referensi: form.jenis_referensi_id,
          nama: form.nama,
          deskripsi: form.deskripsi,
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
    return { form,submit };
  },
  beforeMount() {
    // const id_jenis_referensi = localStorage.getItem("id_filter")
    this.form.jenis_referensi_id = localStorage.getItem("id_filter");
  },
};
</script>
