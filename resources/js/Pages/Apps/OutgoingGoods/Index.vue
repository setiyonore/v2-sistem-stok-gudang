<template>
    <Head>
        <title>Barang Keluar - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                <span class="font-weight-bold"
                ><i class="fas fa-box"></i> Barang Keluar</span
                >
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
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
                                        <th scope="col">Pelanggan</th>
                                        <th scope="col">No Sp</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" style="width: 30%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(data, index) in barang_keluar.data"
                                        :key="index"
                                    >
                                        <td>{{ data.tanggal }}</td>
                                        <td>{{ data.pelanggan }}</td>
                                        <td>{{ data.no_sp }}</td>
                                        <td>{{ data.status }}</td>
                                        <td class="text-center">
                                            <Link
                                                :href="`/apps/outgoing_goods/${data.id}`"
                                                v-if="hasAnyPermission(['barang_keluar.index'])"
                                                class="btn btn-primary btn-sm me-2"
                                            ><i class="fas fa-eye"></i> DETIL
                                            </Link>
                                            <button
                                                @click="print(data.id)"
                                                class="btn btn-info btn-sm"
                                            >
                                                <i class="fa fa-print"></i> PRINT
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="barang_keluar.links" align="end"/>
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
import {Head, Link} from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
        Pagination,
    },
    props: {
        barang_keluar: Array,
    },
    methods: {
        print(id) {
            window.open(`/apps/permintaan/print?id=${id}`, '_blank');
        },
    },
    setup() {
        const search = ref("" || new URL(document.location).searchParams.get("q"));
        const handleSearch = () => {
            Inertia.get("/apps/outgoing_goods", {
                q: search.value,
            });
        };
        return {search, handleSearch};
    },
};
</script>
