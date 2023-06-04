<template>
    <Head>
        <title>Tambah Role - Sistem Informasi Stok Gudang</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fas fa-user-shield"></i> Tambah Roles</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <label class="fw-bold">
                                            Nama Role
                                        </label>
                                        <input class="form-control" v-model="form.name"
                                               :class="{ 'is-invalid': errors.name }" type="text"
                                               placeholder="Role Name">

                                        <div v-if="errors.name" class="alert alert-danger">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label class="font-weight-bold">Hak Akses</label>
                                        <br>
                                        <div class="form-check form-check-inline"
                                             v-for="(permission,index) in permissions" :key="index">
                                            <input class="form-check-input" type="checkbox" v-model="form.permissions"
                                                   :value="permission.name" :id="`check-${permission.id}`">
                                            <label class="form-check-label"
                                                   :for="`check-${permission.id}`">{{ permission.name }}</label>
                                        </div>
                                        <div v-if="errors.permissions" class="alert alert-danger">
                                            {{ errors.permissions }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Simpan
                                            </button>
                                            <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">
                                                Reset
                                            </button>
                                        </div>
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
import {Link, Head} from "@inertiajs/inertia-vue3";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
import Swal from "sweetalert2";

export default {
    name: "create",
    layout: LayoutApp,
    components: {
        Head,
        Link
    },
    props: {
        errors: Object,
        permissions: Array,
    },
    setup() {
        const form = reactive({
            name: '',
            permissions: [],
        });
        const submit = () => {
            Inertia.post('/apps/roles', {
                name: form.name,
                permissions: form.permissions
            }, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success !',
                        text: 'Data Role Berhasil Disimpan',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000,
                    })
                }
            })
        }
        return {form, submit}
    }
}
</script>

<style scoped>

</style>
