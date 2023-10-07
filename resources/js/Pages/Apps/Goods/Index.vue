<template>
    <Head>
        <title>Barang - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                <span class="font-weight-bold"
                ><i class="fas fa-boxes"></i
                ></span>
                                Barang
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
                                        <Link
                                            href="/apps/goods/create"
                                            v-if="hasAnyPermission(['barang.add'])"
                                            class="btn btn-primary input-group-text"
                                        ><i class="fa fa-plus-circle me-2"></i> Tambah
                                        </Link>
                                        <input
                                            type="text"
                                            v-model="search"
                                            class="form-control"
                                            placeholder="Cari berdasarkan nama ..."
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
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col" style="width: 30%">Actions</th>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data, index) in barang.data" :key="index">
                                        <td>{{ data.nama }}</td>
                                        <td>{{ data.satuan }}</td>
                                        <td>{{ data.kategori }}</td>
                                        <td>{{ data.stok }}</td>
                                        <td class="text-center">
                                            <Link
                                                class="btn btn-primary btn-sm me-2"
                                                :href="`/apps/goods/${data.id}`"
                                            ><i class="fas fa-eye"></i> Detil
                                            </Link>
                                            <Link
                                                :href="`/apps/goods/${data.id}/edit`"
                                                v-if="hasAnyPermission(['barang.edit'])"
                                                class="btn btn-success btn-sm me-2"
                                            ><i class="fa fa-pencil-alt me-1"></i> EDIT
                                            </Link>
                                            <button
                                                @click.prevent="destroy(data.id)"
                                                v-if="hasAnyPermission(['barang.delete'])"
                                                class="btn btn-danger btn-sm"
                                            >
                                                <i class="fa fa-trash"></i> DELETE
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="barang.links" align="end"/>
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
import Pagination from "../../../Components/Pagination.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
import {ref} from "@vue/reactivity";
import {Inertia} from "@inertiajs/inertia";
import Swal from "sweetalert2";
import axios from "axios"

export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
        Pagination,
    },
    props: {
        barang: Array,
    },
    setup() {
        const search = ref("" || new URL(document.location).searchParams.get("q"));
        const handleSearch = () => {
            Inertia.get("/apps/goods", {
                q: search.value,
            });
        };
        const destroy = (id) => {
            axios.get(`/apps/barang/checkUsage/${id}`)
                .then((response) => {
                    if (response.data.usage === 1) {
                        Swal.fire({
                            title: "Info !!!",
                            text: "Anda Tidak dapat Menghapus Data,Karena Digunakan Pada Barang Masuk / Barang Keluar ?",
                            icon: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Oke",
                        })
                    } else {
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
                                Inertia.delete(`/apps/goods/${id}`);
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
        return {search, handleSearch, destroy};
    },
};
</script>
