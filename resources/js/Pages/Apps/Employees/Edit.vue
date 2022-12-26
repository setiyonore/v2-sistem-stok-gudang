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
              <div class="card-body"></div>
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
    jabatan: Array,
  },
};
</script>
