<template>
  <Head>Edit User - Sistem Informasi Stok Gudang</Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-font-weight-bold"
                  ><i class="fas fa-user"></i> Edit user</span
                >
              </div>
              <div class="card-body">
                <form @submit.prevent="submit">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="fw-bold">Name</label>
                        <input
                          class="form-control"
                          v-model="form.name"
                          :class="{ 'is-invalid': errors.name }"
                          type="text"
                          placeholder="Name"
                        />
                      </div>
                      <div v-if="errors.name" class="alert alert-danger">
                        {{ errors.name }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="email">Email</label>
                        <input
                          type="text"
                          class="form-control"
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
                        <label class="fw-bold">Password</label>
                        <input
                          class="form-control"
                          v-model="form.password"
                          :class="{ 'is-invalid': errors.password }"
                          type="password"
                          placeholder="Password"
                        />
                      </div>
                      <div v-if="errors.password" class="alert alert-danger">
                        {{ errors.password }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="fw-bold">Password Confirmation</label>
                        <input
                          class="form-control"
                          v-model="form.password_confirmation"
                          type="password"
                          placeholder="Password Confirmation"
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
                      <div v-if="errors.jabatan" class="alert alert-danger">
                        {{ errors.jabatan }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="roles" class="font-weight-bold"
                          >Roles</label
                        >
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
                          />
                          <label :for="`check-${role.id}`">{{
                            role.name
                          }}</label>
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
                        UPDATE
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
import { Link, Head } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
export default {
  layout: LayoutApp,
  components: {
    Head,
    Link,
  },
  props: {
    errors: Object,
    user: Object,
    roles: Array,
    pegawai: Array,
  },
  setup(props) {
    const form = reactive({
      name: props.user.name,
      email: props.user.email,
      password: "",
      password_confirmation: "",
      pegawai: props.user.pegawai_id,
      roles: props.user.roles.map((obj) => obj.name),
    });
    const submit = () => {
      Inertia.put(
        `/apps/users/${props.user.id}`,
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
              text: "Data User Berhasil Diupdate",
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
