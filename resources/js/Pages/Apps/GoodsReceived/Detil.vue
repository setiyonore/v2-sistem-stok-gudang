<template>
    <Head>
        <title>Detil Barang Masuk - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                <span class="font-weight-bold"
                ><i class="fas fa-box-open"></i> Detil Barang Masuk</span
                >
                            </div>
                            <div class="card-body">
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>Tanggal:</b> {{ barang_masuk.tanggal }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>Yang Menyerahkan:</b>
                                            {{ barang_masuk.yang_menyerahkan }}
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>No SP:</b> {{ barang_masuk.no_sp }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>Keterangan:</b> {{ barang_masuk.keterangan }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>Pegawai:</b> {{ barang_masuk.pegawai }}
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="background-color: #e6e6e7">
                                        <th scope="col">No</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">No Serial</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in barang" :key="item.barang">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.barang }}</td>
                                        <td>{{ item.no_serial }}</td>
                                    </tr>
                                    </tbody>
                                </table>
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

export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
    },
    props: {
        barang_masuk: Object,
        barang: Array,
    },
};
</script>
