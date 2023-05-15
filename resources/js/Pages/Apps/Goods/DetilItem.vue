<template>
    <head>
        <title>Detil Item Barang - Sistem Informasi Stok Gudang</title>
    </head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0 rounded-3 shadow border-top-purple">
                                <div class="card-header">
                  <span class="font-weight-bold"
                  ><i class="fas fa-boxes"></i> Detil Item
                    {{ barang.nama }}</span
                  >
                                </div>
                                <div class="card-body">
                                    <form action="">
                                        <div class="input-group mb-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Cari berdasarkan no serial ..."
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
                                        <th scope="col">No</th>
                                        <th scope="col">Nomor Serial</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Kondisi</th>
                                        <th scope="col" style="width: 30%">Action</th>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(data, index) in item.data" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ data.no_serial }}</td>
                                            <td>{{ data.status }}</td>
                                            <td>{{ data.kondisi }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-sm me-2"

                                                ><i class="fas fa-history"></i> History Item
                                                </button>
                                                <Link
                                                    v-if="hasAnyPermission(['barang.edit'])"
                                                    class="btn btn-success btn-sm me-2"
                                                ><i class="fa fa-pencil-alt me-1"></i> EDIT
                                                </Link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
import {Head, Link} from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
        Pagination,
    },
    props: {
        barang: Object,
        item: Object,
    },
    setup() {
    },
};
</script>
