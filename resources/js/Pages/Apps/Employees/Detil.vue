<template>
  <Head>
    <title>Detil Pegawai - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-address-card"></i> Detil Pegawai</span
                >
              </div>
              <div class="card-body">
                <hr />
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3"><b>Nama:</b> {{ pegawai.nama }}</div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3"><b>NIP:</b> {{ pegawai.nip }}</div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <b>Tanggal Lahir:</b> {{ pegawai.tgl_lahir }}
                    </div>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <b>Jabatan:</b> {{ pegawai.jabatan }}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3"><b>No Hp:</b> {{ pegawai.no_hp }}</div>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="mb-3"><b>Alamat:</b> {{ pegawai.alamat }}</div>
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
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    pegawai: Object,
  },
};
</script>
