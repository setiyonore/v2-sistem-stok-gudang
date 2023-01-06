<template>
  <Head>
    <title>Barang Masuk - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-box-open"></i> Barang Masuk</span
                >
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <Link
                      href="/apps/received_goods/create"
                      v-if="hasAnyPermission(['barang_masuk.add'])"
                      class="btn btn-primary input-group-text"
                      ><i class="fa fa-plus-circle me-2"></i> Tambah
                    </Link>
                    <input
                      type="date"
                      v-model="search"
                      class="form-control"
                      placeholder="Cari barang masuk berdasarkan tanggal..."
                    />

                    <button
                      class="btn btn-primary input-group-text"
                      type="submit"
                    >
                      <i class="fa fa-search me-2"></i> Cari
                    </button>
                  </div>
                </form>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Tanggal</th>
                      <th scope="col">Yang Menyerahkan</th>
                      <th scope="col">Pegawai</th>
                      <th scope="col">Keterangan</th>
                      <th scope="col" style="width: 30%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data, index) in barang_masuk.data" :key="index">
                      <td>{{ data.tanggal }}</td>
                      <td>{{ data.yang_menyerahkan }}</td>
                      <td>{{ data.pegawai }}</td>
                      <td>{{ data.keterangan }}</td>
                      <td class="text-center">
                        <Link
                          :href="`/apps/employees/${data.id}/edit`"
                          v-if="hasAnyPermission(['roles.edit'])"
                          class="btn btn-success btn-sm me-2"
                          ><i class="fa fa-pencil-alt me-1"></i> EDIT
                        </Link>
                        <Link
                          :href="`/apps/employees/${data.id}`"
                          v-if="hasAnyPermission(['roles.edit'])"
                          class="btn btn-primary btn-sm me-2"
                          ><i class="fas fa-eye"></i> DETIL
                        </Link>
                        <button
                          @click.prevent="destroy(data.id)"
                          v-if="hasAnyPermission(['roles.delete'])"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fa fa-trash"></i> DELETE
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="barang_masuk.links" align="end" />
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
import { Inertia } from "@inertiajs/inertia";
import Pagination from "../../../Components/Pagination.vue";
import { ref } from "vue";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    barang_masuk: Array,
  },
  setup() {
    const search = ref("" || new URL(document.location).searchParams.get("q"));
    const handleSearch = () => {
      Inertia.get("/apps/received_goods", {
        q: search.value,
      });
    };
    return { search, handleSearch };
  },
};
</script>
