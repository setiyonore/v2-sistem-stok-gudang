<template>
  <Head>
    <title>Referensi - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-list-ul"></i
                ></span>
                Referensi
              </div>
              <div class="card-body">
                <form>
                  <div class="input-group mb-3">
                    <Link
                      href="/apps/roles/create"
                      v-if="hasAnyPermission(['roles.add'])"
                      class="btn btn-primary input-group-text"
                      ><i class="fa fa-plus-circle me-2"></i> Tambah
                    </Link>
                    <select
                      class="form-control"
                      aria-label="Default select example"
                    >
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
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
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    jenis_refernsi: Object,
  },
};
</script>
