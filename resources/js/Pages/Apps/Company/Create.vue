<template>
  <Head>
    <title>Tambah Perusahaan - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-building"></i> Tambah Perusahaan</span
                >
              </div>
              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="md-3">
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
                      <div class="md-3">
                        <label for="nama" class="font-weight-bold">Email</label>
                        <input
                          type="text"
                          class="form-control"
                          :class="{ 'is-invalid': errors.email }"
                          v-model="form.email"
                        />
                      </div>
                      <div v-if="errors.email" class="alert alert-danger">
                        {{ errors.email }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="md-3">
                        <label for="nama" class="font-weight-bold">No Hp</label>
                        <input
                          type="text"
                          class="form-control"
                          :class="{ 'is-invalid': errors.no_hp }"
                          v-model="form.no_hp"
                        />
                      </div>
                      <div v-if="errors.no_hp" class="alert alert-danger">
                        {{ errors.no_hp }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="jenis" class="font-weight-bold"
                          >Jenis Perusahaan</label
                        >
                        <select
                          class="form-select"
                          aria-label="Default select example"
                          v-model="form.jenis_perusahaan"
                        >
                          <option value="">Pilih Jenis Perusahaan</option>
                          <option
                            v-for="(data, index) in jenis"
                            :key="index"
                            :value="data.id"
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                      <div
                        v-if="errors.jenis_perusahaan"
                        class="alert alert-danger"
                      >
                        {{ errors.jenis_perusahaan }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="md-3">
                        <label for="no_hp" class="font-weight-bold">PIC</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.pic"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="md-3">
                        <label for="no_hp" class="font-weight-bold"
                          >No Hp PIC</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.no_pic"
                        />
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
                          :class="{ 'is-invalid': errors.alamat }"
                        ></textarea>
                      </div>
                      <div v-if="errors.alamat" class="alert alert-danger">
                        {{ errors.alamat }}
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
    jenis: Array,
    errors: Object,
  },
  setup() {
    const form = reactive({
      nama: "",
      no_hp: "",
      email: "",
      pic: "",
      no_pic: "",
      jenis_perusahaan: "",
      alamat: "",
    });
    const submit = () => {
      Inertia.post(
        "/apps/company",
        {
          nama: form.nama,
          no_hp: form.no_hp,
          email: form.email,
          pic: form.pic,
          no_pic: form.no_pic,
          jenis_perusahaan: form.jenis_perusahaan,
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
