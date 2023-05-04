<template>
    <Head>
        <title>Edit Barang Masuk - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                <span class="font-weight-bold"
                ><i class="fas fa-box-open"></i> Edit Barang Masuk</span
                >
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal" class="font-weight-bold">
                                                Tanggal
                                            </label>
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
                                            <label for="yang menyerahkan" class="font-weight-bold"
                                            >Yang Menyerahkan</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.yang_menyerahkan"
                                                :class="{ 'is-invalid': errors.yang_menyerahkan }"
                                            />
                                        </div>
                                        <div
                                            v-if="errors.yang_menyerahkan"
                                            class="alert alert-danger"
                                        >
                                            {{ errors.yang_menyerahkan }}
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
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no_sp" class="font-weight-bold"
                                            >No Sp</label
                                            >
                                            <input type="text"
                                                   class="form-control"
                                                   v-model="form.no_sp"
                                                   :class="{ 'is-invalid': errors.no_sp }">
                                        </div>
                                        <div v-if="errors.no_sp" class="alert alert-danger">
                                            {{ errors.no_sp }}
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
                                                :options="goods"
                                                class="form-control"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="no_serial" class="font-weight-bold"
                                            >No Serial</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.no_serial"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-white">*</label>
                                            <button
                                                class="btn btn-md btn-success border-0 shadow w-100"
                                                @click="addBarang"
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
                                    <tr v-for="(item, index) in barang" :key="item.barang_id">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <Select2
                                                v-model="item.barang_id"
                                                :options="goods"
                                                :settings="{ width: '100%' }"
                                            />
                                        </td>
                                        <td>
                                            <input type="text" v-model="item.no_serial"/>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-danger btn-sm rounded-pill"
                                                @click="deleteBarang(index,item.item_id)"
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
import {reactive} from "vue";
import Select2 from "vue3-select2-component";
import axios from "axios";
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";

export default {
    layout: LayoutApp,
    components: {
        Head,
        Link,
        Select2,
    },
    props: {
        barang_masuk: Object,
        barang: Array,
        errors: Object,
        goods: Array,
    },
    methods: {
        addBarang() {
            axios
                .post(`/apps/barang_masuk/searchGood`, {
                    id_barang: this.form.barang,
                })
                .then((response) => {
                    if (this.form.barang == "" || this.form.jumlah == "") {
                        Swal.fire({
                            title: "Warning !",
                            text: "Isi Barang Dan Jumlah !!!",
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    } else {
                        this.barang.push({
                            barang_id: this.form.barang,
                            no_serial: this.form.no_serial,
                            nama: response.data.nama,
                            item_id: 0,
                        });
                        this.form.barang = "";
                        this.form.no_serial = "";
                    }
                });
        },
        deleteBarang(index,item) {
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
                    axios.get(`/apps/barang_masuk/deleteItem/${item}`)
                        .then((response)=>{
                            console.log(response.data)
                            if(response.data === 'success'){
                                this.barang.splice(index, 1);
                            }
                        })
                }
            });
        },
        submit() {
            Inertia.put(
                `/apps/received_goods/${this.barang_masuk.id}`,
                {
                    id: this.barang_masuk.id,
                    tanggal: this.form.tanggal,
                    yang_menyerahkan: this.form.yang_menyerahkan,
                    keterangan: this.form.keterangan,
                    no_sp: this.form.no_sp,
                    barang: this.barang,
                },
                {
                    onSuccess: () => {
                        Swal.fire({
                            title: "Success !",
                            text: "Data Berhasil di Update",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    },
                }
            );
        },
        reset() {
            this.form.tanggal = "";
            this.form.yang_menyerahkan = "";
            this.form.keterangan = "";
            this.form.penyedia = "";
            this.barang = "";
        },
    },
    setup(props) {
        const form = reactive({
            tanggal: props.barang_masuk.tanggal,
            yang_menyerahkan: props.barang_masuk.yang_menyerahkan,
            keterangan: props.barang_masuk.keterangan,
            no_sp: props.barang_masuk.no_sp,
            barang: "",
            no_serial: "",
        });
        return {form};
    },
};
</script>
