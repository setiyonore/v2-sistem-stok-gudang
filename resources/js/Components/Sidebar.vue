<template>
  <ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item">
      <Link
        class="c-sidebar-nav-link"
        v-if="hasAnyPermission(['dashboard.index'])"
        :class="{ active: $page.url.startsWith('/apps/dashboard') }"
        href="/apps/dashboard"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-speedometer2"
          viewBox="0 0 16 16"
        >
          <path
            d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"
          />
          <path
            fill-rule="evenodd"
            d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"
          />
        </svg>
        <span class="ms-2">Dashboard</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-title"
      v-if="
        hasAnyPermission(['barang_masuk.index']) ||
        hasAnyPermission(['barang_keluar.index']) ||
        hasAnyPermission(['order.index'])
      "
    >
      TRANSAKSI
    </li>
    <li
      class="c-sidebar-nav-item"
      v-if="hasAnyPermission(['barang_masuk.index'])"
    >
      <Link
        class="c-sidebar-nav-link"
        href="/apps/received_goods"
        :class="{ active: $page.url.startsWith('/apps/received_goods') }"
      >
        <i class="fas fa-box-open"></i>
        <span class="ms-2">Barang Masuk</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-item"
      v-if="hasAnyPermission(['order.index'])"
    >
      <Link
        class="c-sidebar-nav-link"
        href="/apps/order"
        :class="{ active: $page.url.startsWith('/apps/order') }"
      >
        <i class="fas fa-envelope-open-text"></i>
        <span class="ms-2">Order Barang</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-item"
      v-if="hasAnyPermission(['barang_keluar.index'])"
    >
      <Link
        class="c-sidebar-nav-link"
        href="/apps/outgoing_goods"
        :class="{ active: $page.url.startsWith('/apps/outgoing_goods') }"
      >
        <i class="fas fa-box"></i>
        <span class="ms-2">Barang Keluar</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-title"
      v-if="
        hasAnyPermission(['referensi.index']) ||
        hasAnyPermission(['jenis_referensi.index']) ||
        hasAnyPermission(['barang.index']) ||
        hasAnyPermission(['perusahaan.index']) ||
        hasAnyPermission(['pegawai.index'])
      "
    >
      MASTER
    </li>
    <li class="c-sidebar-nav-item" v-if="hasAnyPermission(['barang.index'])">
      <Link
        class="c-sidebar-nav-link"
        href="/apps/goods"
        :class="{ active: $page.url.startsWith('/apps/goods') }"
      >
        <i class="fas fa-boxes"></i>
        <span class="ms-2">Barang</span>
      </Link>
    </li>
    <li class="c-sidebar-nav-item" v-if="hasAnyPermission(['pegawai.index'])">
      <Link
        class="c-sidebar-nav-link"
        href="/apps/employees"
        :class="{ active: $page.url.startsWith('/apps/employees') }"
      >
        <i class="fas fa-address-card"></i>
        <span class="ms-2">Pegawai</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-item"
      v-if="hasAnyPermission(['perusahaan.index'])"
    >
      <Link
        class="c-sidebar-nav-link"
        href="/apps/company"
        :class="{ active: $page.url.startsWith('/apps/company') }"
      >
        <i class="fas fa-building"></i>
        <span class="ms-2">Perusahaan</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-item"
      v-if="hasAnyPermission(['jenis_referensi.index'])"
    >
      <Link
        class="c-sidebar-nav-link"
        href="/apps/type_references"
        :class="{ active: $page.url.startsWith('/apps/type_references') }"
      >
        <i class="fas fa-list"></i>
        <span class="ms-2">Jenis Referensi</span>
      </Link>
    </li>
    <li class="c-sidebar-nav-item" v-if="hasAnyPermission(['referensi.index'])">
      <Link
        class="c-sidebar-nav-link"
        href="/apps/references"
        :class="{
          active:
            $page.url.startsWith('/apps/references') ||
            $page.url.startsWith('/apps/referensi'),
        }"
      >
        <i class="fas fa-list-ul"></i>
        <span class="ms-2">Referensi</span>
      </Link>
    </li>
    <li
      class="c-sidebar-nav-title"
      v-if="
        hasAnyPermission(['roles.index']) || hasAnyPermission(['user.index'])
      "
    >
      USER MANAGEMENT
    </li>

    <li class="c-sidebar-nav-item" v-if="hasAnyPermission(['roles.index'])">
      <Link
        class="c-sidebar-nav-link"
        href="/apps/roles"
        :class="{ active: $page.url.startsWith('/apps/roles') }"
      >
        <i class="fas fa-user-shield"></i>
        <span class="ms-2">Roles</span>
      </Link>
    </li>
    <li class="c-sidebar-nav-item" v-if="hasAnyPermission(['user.index'])">
      <Link
        class="c-sidebar-nav-link"
        href="/apps/users"
        :class="{ active: $page.url.startsWith('/apps/users') }"
      >
        <i class="fas fa-users"></i>
        <span class="ms-2">Users</span>
      </Link>
    </li>

    <li class="c-sidebar-nav-divider"></li>
  </ul>
</template>

<script>
//import Link
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
};
</script>

<style>
</style>
