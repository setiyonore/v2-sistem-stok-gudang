<template>
  <Head>
    <title>Tambah Pegawai - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-address-card"></i> Tambah Pegawai</span
                >
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
                          v-model="form.nama"
                          :class="{ 'is-invalid': errors.nama }"
                        />
                      </div>
                      <div v-if="errors.nama" class="alert alert-danger">
                        {{ errors.nama }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="nama" class="font-weight-bold">NIP</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.nip"
                          :class="{ 'is-invalid': errors.nip }"
                        />
                      </div>
                      <div v-if="errors.nip" class="alert alert-danger">
                        {{ errors.nip }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="nama" class="font-weight-bold"
                          >Tanggal Lahir</label
                        >
                        <input
                          type="date"
                          class="form-control"
                          v-model="form.tanggal_lahir"
                          :class="{ 'is-invalid': errors.tanggal_lahir }"
                        />
                      </div>
                      <div
                        v-if="errors.tanggal_lahir"
                        class="alert alert-danger"
                      >
                        {{ errors.tanggal_lahir }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="jenis" class="font-weight-bold"
                          >Jabatan</label
                        >
                        <select
                          class="form-select"
                          aria-label="Default select example"
                          v-model="form.jabatan"
                        >
                          <option value="">Pilih Jabatan</option>
                          <option
                            v-for="(data, index) in jabatan"
                            :key="index"
                            :value="data.id"
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                      <div v-if="errors.jabatan" class="alert alert-danger">
                        {{ errors.jabatan }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="alamat" class="font-weight-bold"
                          >Alamat</label
                        >
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="form.alamat"
                          :class="{ 'is-invalid': errors.no_hp }"
                        ></textarea>
                      </div>
                      <div v-if="errors.alamat" class="alert alert-danger">
                        {{ errors.alamat }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="no_hp" class="font-weight-bold"
                          >No Hp</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.no_hp"
                          :class="{ 'is-invalid': errors.no_hp }"
                        />
                      </div>
                      <div
                        v-if="errors.no_hp"
                        class="alert alert-danger"
                      >
                        {{ errors.no_hp }}
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
    jabatan: Array,
    errors: Object,
  },
  setup() {
    const form = reactive({
      nama: "",
      jabatan: "",
      tanggal_lahir: "",
      nip: "",
      no_hp: "",
      alamat: "",
    });
    const submit = () => {
      Inertia.post(
        "/apps/employees",
        {
          nama: form.nama,
          jabatan: form.jabatan,
          tanggal_lahir: form.tanggal_lahir,
          nip: form.nip,
          no_hp: form.no_hp,
          alamat: form.alamat,
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
