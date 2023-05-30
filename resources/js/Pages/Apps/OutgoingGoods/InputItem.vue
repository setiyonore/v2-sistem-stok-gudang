<template>
  <Head>
    <title>Input Item Order - Sistem Informasi Stok Gudang</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold">
                  Input Item Barang Keluar - SP : {{ order.no_sp }}
                </span>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr style="background-color: #e6e6e7">
                      <th scope="col">No</th>
                      <th scope="col">Nama Barang</th>
                      <th scope="col">No Serial</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="item.id">
                      <td>{{ index + 1 }}</td>
                      <td>{{ item.nama }}</td>
                      <td>
                        <input
                          type="text"
                          class="form-control"
                          v-model="item.serial"
                          @change="addItem(index)"
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>
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
import { Head } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { reactive } from "vue";
export default {
  layout: LayoutApp,
  components: { Head },
  props: {
    items: Array,
    order: String,
  },
  data() {
    return {
      item_tmp: [],
    };
  },
  methods: {
    addItem(index) {
      let itemArray = this.item_tmp;
      let newData = this.items[index];
      if (itemArray.some((obj) => obj.serial === newData.serial)) {
        Swal.fire({
          title: "Warning !",
          text: `No Serial "${newData.serial}" sudah diinputkan sebelumnya`,
          icon: "warning",
          showConfirmButton: true,
        });
        newData.serial = "";
      } else {
        axios
          .post(`/apps/barang_keluar/searchSerial/`, {
            serial: newData.serial,
            barang_id: newData.barang_id,
          })
          .then((response) => {
            //cek serial
            if (response.data.match == 1) {
              //cek kondisi
              if (response.data.normal == 0) {
                Swal.fire({
                  title: "Warning !",
                  text: `Kondisi barang yang diminta tidak normal`,
                  icon: "warning",
                  showConfirmButton: true,
                });
                newData.serial = "";
              } else {
                //cek available barang
                axios
                  .get(`/apps/barang_keluar/availableItem/${newData.serial}`)
                  .then((response) => {
                    if (response.data.avail == 0) {
                      Swal.fire({
                        title: "Warning !",
                        text: `${newData.nama} dengan Serial "${newData.serial}" Tidak Tersedia`,
                        icon: "warning",
                        showConfirmButton: true,
                      });
                      newData.serial = "";
                    } else {
                      itemArray.push(newData);
                    }
                  });
              }
            } else {
              Swal.fire({
                title: "Warning !",
                text: `${newData.nama} No Serial "${newData.serial}" tidak ditemukan`,
                icon: "warning",
                showConfirmButton: true,
              });
              newData.serial = "";
            }
          });
      }
    },
    submit() {
      for (let i = 0; i < this.items.length; i++) {
        if (this.items[i]["serial"].length == 0) {
          Swal.fire({
            title: "Warning !",
            text: `Mohon Inputkan No Serial Pada "${this.items[i]["nama"]}"`,
            icon: "warning",
            showConfirmButton: true,
          });
        } else {
          Inertia.post(
            "/apps/barang_keluar/insertItem",
            {
              barang: this.form.barang,
              no_sp: this.order.no_sp,
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
      }
    },
  },
  setup(props) {
    const form = reactive({
      barang: props.items,
    });
    return { form };
  },
};
</script>
