<template>
  <head>
    <title>Tambah User - Sistem Informasi Stok Gudang</title>
  </head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fas fa-users"></i> Tambah User</span
                >
              </div>
              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="font-weight-bold">Nama</label>
                        <input
                          class="form-control"
                          v-model="form.name"
                          :class="{ 'is-invalid': errors.name }"
                          type="text"
                          placeholder="Nama"
                        />
                      </div>
                      <div v-if="errors.name" class="alert alert-danger">
                        {{ errors.name }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="font-weight-bold">Email</label>
                        <input
                          class="form-control"
                          type="email"
                          v-model="form.email"
                          :class="{ 'is-invalid': errors.email }"
                          placeholder="Email"
                        />
                      </div>
                      <div v-if="errors.email" class="alert alert-danger">
                        {{ errors.email }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="font-weight-bold">Password</label>
                        <input
                          type="password"
                          class="form-control"
                          v-model="form.password"
                          :class="{ 'is-invalid': errors.password }"
                          placeholder="Password"
                        />
                      </div>
                      <div v-if="errors.password" class="alert alert-danger">
                        {{ errors.password }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="font-weight-bold"
                          >Konfirmasi Password</label
                        >
                        <input
                          type="password"
                          class="form-control"
                          v-model="form.password_confirmation"
                          placeholder="Konfirmasi Password"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="jenis" class="font-weight-bold"
                          >Pegawai</label
                        >
                        <select
                          class="form-select"
                          aria-label="Default select example"
                          v-model="form.pegawai"
                        >
                          <option value="">Pilih Pegawai</option>
                          <option
                            v-for="(data, index) in pegawai"
                            :key="index"
                            :value="data.id"
                          >
                            {{ data.nama }}
                          </option>
                        </select>
                      </div>
                      <div v-if="errors.pegawai" class="alert alert-danger">
                        {{ errors.pegawai }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="font-weight-bold">Roles</label>
                        <br />
                        <div
                          class="form-check form-check-inline"
                          v-for="(role, index) in roles"
                          :key="index"
                        >
                          <input
                            type="checkbox"
                            class="form-check-input"
                            v-model="form.roles"
                            :value="role.name"
                            :id="`check-${role.id}`"
                          />
                          <label
                            class="form-check-label"
                            :for="`check-${role.id}`"
                            >{{ role.name }}</label
                          >
                        </div>
                      </div>
                      <div v-if="errors.roles" class="alert alert-danger">
                        {{ errors.roles }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button
                        class="btn btn-primary shadow-sm rounded-sm"
                        type="submit"
                      >
                        SAVE
                      </button>
                      <button
                        class="btn btn-warning shadow-sm rounded-sm ms-3"
                        type="reset"
                      >
                        RESET
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";

export default {
  name: "Create",
  layout: LayoutApp,
  components: { Head, Link },
  props: {
    errors: Object,
    roles: Array,
    pegawai: Array,
  },
  setup() {
    const form = reactive({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      pegawai: "",
      roles: [],
    });
    const submit = () => {
      Inertia.post(
        "/apps/users",
        {
          name: form.name,
          email: form.email,
          password: form.password,
          password_confirmation: form.password_confirmation,
          roles: form.roles,
          pegawai: form.pegawai,
        },
        {
          onSuccess: () => {
            Swal.fire({
              title: "Success",
              text: "Data User Berhasil Disimpan",
              icon: "success",
              showConfirmButton: false,
              timer: 2000,
            });
          },
        }
      );
    };
    return { form, submit };
  },
};
</script>

<style scoped>
</style>
