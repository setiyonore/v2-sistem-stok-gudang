<template>
  <Head>
    <title>Edit Pegawai - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-address-card"></i> Edit Pegawai</span
                >
              </div>
              <div class="card-body">
                <form action="">
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
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    pegawai: Object,
    jabatan: Array,
    errors: Object,
  },
  setup(props) {
    const form = reactive({
      nama: props.pegawai.nama,
      jabatan: props.pegawai.jabatan,
      tanggal_lahir: props.tanggal,
      nip: props.pegawai.nip,
      no_hp: props.pegawai.no_hp,
      alamat: props.pegawai.alamat,
    });
    return { form };
  },
};
</script>
