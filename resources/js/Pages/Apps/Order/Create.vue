<template>
    <Head>
        <title>Tambah Order Barang - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                <span class="font-weight-bold"
                ><i class="fas fa-envelope-open-text"></i> Tambah Order
                  Barang</span
                >
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal" class="font-weight-bold"
                                            >Tanggal</label
                                            >
                                            <input
                                                type="date"
                                                class="form-control"
                                                v-model="form.tanggal"
                                                :class="{ 'is-invalid': errors.tanggal }"
                                            />
                                        </div>
                                        <div v-if="errors.tanggal" class="alert alert-danger">
                                            {{ errors.tanggal }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pelanggan" class="font-weight-bold"
                                            >Pelanggan</label
                                            >
                                            <Select2
                                                class="form-control"
                                                v-model="form.pelanggan"
                                                :options="pelanggan"
                                                :settings="{ width: '100%' }"
                                            />
                                        </div>
                                        <div v-if="errors.pelanggan" class="alert alert-danger">
                                            {{ errors.pelanggan }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="keterangan" class="font-weight-bold"
                                            >Keterangan</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.keterangan"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barang" class="font-weight-bold"
                                            >Barang</label
                                            >
                                            <Select2
                                                v-model="form.barang"
                                                :options="barang"
                                                class="form-control"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="jumlah" class="font-weight-bold"
                                            >Jumlah</label
                                            >
                                            <input
                                                type="number"
                                                class="form-control"
                                                v-model="form.jumlah"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-white">*</label>
                                            <button
                                                class="btn btn-md btn-success border-0 shadow w-100"
                                                @click="addBarang"
                                                :disabled="disableBtnTambahBarang"
                                            >
                                                <i class="fa fa-plus"></i> Tambah Barang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="background-color: #e6e6e7">
                                        <th scope="col">No</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in items" :key="item.barang_id">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <Select2
                                                v-model="item.barang_id"
                                                :options="barang"
                                                :settings="{ width: '100%' }"
                                            />
                                        </td>
                                        <td><input type="number" v-model="item.jumlah"/></td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-danger btn-sm rounded-pill"
                                                @click="deleteBarang(index)"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div v-if="errors.barang" class="alert alert-danger">
                                    {{ errors.barang }}
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button
                                            class="btn btn-primary shadow-sm rounded-sm"
                                            type="submit"
                                            @click="submit"
                                        >
                                            Simpan
                                        </button>
                                        <button
                                            class="btn btn-warning shadow-sm rounded-sm ms-3"
                                            type="reset"
                                            @click="reset"
                                        >
                                            Reset
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
import {Inertia} from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Select2 from "vue3-select2-component";
import {reactive} from "vue";
import axios from "axios";

export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
        Select2,
    },
    data() {
        return {
            items: [],
        };
    },
    props: {
        pelanggan: Array,
        barang: Array,
        errors: Object,
    },
    methods: {
        submit() {
            Inertia.post(
                "/apps/order",
                {
                    tanggal: this.form.tanggal,
                    keterangan: this.form.keterangan,
                    pelanggan: this.form.pelanggan,
                    barang: this.items,
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
        },
        addBarang() {
            axios
                .post(`/apps/permintaan/searchGood`, {
                    id_barang: this.form.barang,
                    jumlah: this.form.jumlah,
                })
                .then((response) => {
                    if (response.data.available == 0) {
                        Swal.fire({
                            title: "Warning !",
                            text: "Stok barang tidak tersedia di Gudang saat Ini,mohon menunggu barang dari Pusat",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        this.items.push({
                            barang_id: this.form.barang,
                            jumlah: this.form.jumlah,
                            nama: response.data.barang.nama,
                        });
                        this.form.barang = "";
                        this.form.jumlah = "";
                    } else {
                        this.items.push({
                            barang_id: this.form.barang,
                            jumlah: this.form.jumlah,
                            nama: response.data.barang.nama,
                        });
                        this.form.barang = "";
                        this.form.jumlah = "";
                    }
                });
        },
        deleteBarang(index) {
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
                    this.items.splice(index, 1);
                }
            });
        },
    },
    setup() {
        const form = reactive({
            tanggal: "",
            keterangan: "",
            pelanggan: "",
            barang: "",
            jumlah: "",
        });

        return {form};
    },
};
</script>
