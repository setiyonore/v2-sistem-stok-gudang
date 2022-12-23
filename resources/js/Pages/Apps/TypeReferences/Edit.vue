<template>
  <Head>
    <title>Edit Jenis Referensi - Sistem Informasi Stok Gudang</title>
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
                Edit Jenis Referensi
              </div>
              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="name" class="font-weight-bold">Nama</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.nama"
                          :class="{ 'is-invalid': errors.nama }"
                        />
                        <div v-if="errors.nama" class="alert alert-danger">
                          {{ errors.nama }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="description" class="font-weight-bold"
                          >Deskripsi</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.deskripsi"
                          :class="{ 'is-invalid': errors.deskripsi }"
                        />
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
    errors: Object,
    jenis_referensi: Object,
  },
  setup(props) {
    const form = reactive({
      nama: props.jenis_referensi.nama,
      deskripsi: props.jenis_referensi.deskripsi,
    });
    const submit = () => {
      Inertia.post(
        `/apps/type_references/${props.jenis_referensi.id}`,
        {
          _method: "PUT",
          id: props.jenis_referensi.id,
          nama: form.nama,
          deskripsi: form.deskripsi,
        },
        {
          onSuccess: () => {
            Swal.fire({
              title: "Success",
              text: "Data Berhasil Diupdate",
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
