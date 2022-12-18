<template>
  <Head>
    <title>Tambah Jenis Referensi - Sistem Informasi Stok Gudang</title>
    <main class="c-main">
      <div class="container-fluid">
        <div class="fade-in">
          <div class="row">
            <div class="col-md-12">
              <div class="card border-0 rounded-3 shadow border-top-purple">
                <div class="card-border">
                  <span class="font-weight-bold">
                    <i class="fas fa-list"></i> Tambah Jenis Referensi
                  </span>
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
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    errors: Object,
  },
  setup() {
    const form = reactive({
      nama: "",
      deskripsi: "",
    });
    const submit = () => {
      Inertia.post(
        "/apps/type_references",
        {
          nama: form.nama,
          deskripsi: form.deskripsi,
        },
        {
          onSuccess: () => {
            Swal.fire({
              title: "Success",
              text: "Data Jenis Referensi Berhasil Disimpan",
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
