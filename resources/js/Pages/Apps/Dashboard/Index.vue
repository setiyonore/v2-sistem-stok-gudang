<template>

    <Head>
        <title>Dashboard - Sistem Informasi Stok Gudang</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> Chart Barang Keluar Masuk 7 Hari</span>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div  class="card border-0 rounded-3 shadow border-top-warning">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fas fa-mail-bulk"></i> Surat Permintaan Pending</span>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 rounded-3 shadow border-top-danger">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-box-open"></i> Stok Barang Dibawah 10</span>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</template>

<script>
//import layout
import LayoutApp from '../../../Layouts/App.vue';

//import Head and useForm from Inertia
import { Head } from '@inertiajs/inertia-vue3';

export default {

    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
    },
}
</script>

<style>

</style>
