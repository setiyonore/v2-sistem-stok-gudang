<template>
  <Head>
    <title>Perusahaan - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-building"></i> Perusahaan</span
                >
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <Link
                      href="/apps/company/create"
                      v-if="hasAnyPermission(['perusahaan.add'])"
                      class="btn btn-primary input-group-text"
                      ><i class="fa fa-plus-circle me-2"></i> Tambah
                    </Link>
                    <input
                      type="text"
                      v-model="search"
                      class="form-control"
                      placeholder="cari perusahaan berdasarkan nama..."
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
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Email</th>
                    <th scope="col">No Hp</th>
                    <th scope="col" style="width: 30%">Actions</th>
                  </thead>
                  <tbody>
                    <tr v-for="(data, index) in perusahaan.data" :key="index">
                      <td>{{ data.nama }}</td>
                      <td>{{ data.alamat }}</td>
                      <td>{{ data.email }}</td>
                      <td>{{ data.no_hp }}</td>
                      <td class="text-center">
                        <Link
                          :href="`/apps/company/${data.id}/edit`"
                          v-if="hasAnyPermission(['perusahaan.edit'])"
                          class="btn btn-success btn-sm me-2"
                          ><i class="fa fa-pencil-alt me-1"></i> EDIT
                        </Link>
                        <Link
                          :href="`/apps/company/${data.id}`"
                          v-if="hasAnyPermission(['perusahaan.edit'])"
                          class="btn btn-primary btn-sm me-2"
                          ><i class="fas fa-eye"></i> DETIL
                        </Link>
                        <button
                          @click.prevent="destroy(data.id)"
                          v-if="hasAnyPermission(['perusahaan.delete'])"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fa fa-trash"></i> DELETE
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="perusahaan.links" align="end" />
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
import Pagination from "../../../Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import Swal from "sweetalert2";
import axios from "axios";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    perusahaan: Object,
  },
  setup() {
    const search = ref("" || new URL(document.location).searchParams.get("q"));
    const handleSearch = () => {
      Inertia.get("/apps/company", {
        q: search.value,
      });
    };
    const destroy = (id) => {
        axios.get(`/apps/company/checkUsage/${id}`)
            .then((response)=>{
                if (response.data.usage === 1){
                    Swal.fire({
                        title: "Info !!!",
                        text: "Anda Tidak dapat Menghapus Data,Karena Digunakan Pada Order Barang",
                        icon: "warning",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oke",
                    })
                }else{
                    Swal.fire({
                        title: "Konfirmasi !!!",
                        text: "Anda Akan Menghapus Data ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Hapus",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Inertia.delete(`/apps/company/${id}`);
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Di Hapus",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    });
                }
            })

    };
    return { search, handleSearch, destroy };
  },
};
</script>
