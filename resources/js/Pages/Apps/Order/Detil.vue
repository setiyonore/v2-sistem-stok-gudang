<template>
    <Head>
        <title>Detil Order - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                <span class="font-weight-bold"
                ><i class="fas fa-envelope-open-text"></i> Detil Order</span
                >
                            </div>
                            <div class="card-body">
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3"><b>Tanggal:</b> {{ formattedDate }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3"><b>No Sp:</b> {{ order.no_sp }}</div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>Pelanggan:</b> {{ order.pelanggan }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <b>Keterangan:</b> {{ order.keterangan }}
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3"><b>Status:</b> {{ order.ref_status }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3"><b>Pegawai:</b> {{ order.pegawai }}</div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="background-color: #e6e6e7">
                                        <th scope="col">No</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in barang" :key="item.barang">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.nama }}</td>
                                        <td>{{ item.jumlah }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-6">
                                        <button
                                            v-if="
                        hasAnyPermission(['order.approval']) &&
                        order.status == config_status_pending
                      "
                                            class="btn btn-success shadow-sm rounded-sm"
                                            type="submit"
                                            @click="approve"
                                        >
                                            Setujui
                                        </button>
                                        <button
                                            v-if="
                        hasAnyPermission(['order.approval']) &&
                        order.status == config_status_pending
                      "
                                            class="btn btn-warning shadow-sm rounded-sm ms-3"
                                            type="reset"
                                            @click="notApprove"
                                        >
                                            Tolak
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-primary" @click="print">
                                            Print
                                        </button>
                                    </div>
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
import moment from "moment";
import {Inertia} from "@inertiajs/inertia";
import Swal from "sweetalert2";

export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
    },
    props: {
        order: Object,
        barang: Array,
        config_status_pending: String
    },
    methods: {
        approve() {
            Swal.fire({
                title: "Konfirmasi !!!",
                text: "Anda Menyetujui Permintaan Barang ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#6469EB",
                cancelButtonColor: "#d33",
                confirmButtonText: "Setujui",
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.post(
                        "/apps/permintaan/approve",
                        {
                            id: this.order.id,
                        },
                        {
                            onSuccess: () => {
                                Swal.fire({
                                    title: "Success !",
                                    text: "Data Berhasil Disimpan",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            },
                        }
                    );
                }
            });
        },
        notApprove() {
            Swal.fire({
                title: "Konfirmasi !!!",
                text: "Anda Menolak Permintaan Barang ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#EEC122",
                cancelButtonColor: "#6469EB",
                confirmButtonText: "Tolak",
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.post(
                        "/apps/permintaan/notApprove",
                        {
                            id: this.order.id,
                        },
                        {
                            onSuccess: () => {
                                Swal.fire({
                                    title: "Success !",
                                    text: "Data Berhasil Disimpan",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            },
                        }
                    );
                }
            });
        },
        print() {
            window.open(`/apps/permintaan/print?id=${this.order.id}`, '_blank');
        },
    },
    computed: {
        formattedDate() {
            return moment(this.order.tanggal).format("DD/MM/YYYY");
        },
    },
};
</script>
