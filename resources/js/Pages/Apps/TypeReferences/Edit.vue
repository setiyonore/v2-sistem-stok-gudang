<template>
  <Head>
    <title>Edit Jenis Referensi - Sistem Informasi Stok Gudang</title>
    <main class="c-main">
      <div class="container-fluid">
        <div class="fade-in">
          <div class="row">
            <div class="col-md-12">
              <div class="card border-0 shadow border-top-purple">
                <div class="card-header">
                  <span class="font-weight-bold">
                    <i class="fas fa-list"></i> Edit Jenis Referensi
                  </span>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">

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
  </Head>
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
    jenis_referensi: Object,
    errros: Object,
  },
};
</script>
