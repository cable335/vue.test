<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    response: Object,
  },
  methods: {
    isPublic(num = 0) {
      if (![1, 2].includes(num)) return '';
      return num;
    },
    deleteProduct(id) {
      Swal.fire({
        title: '確定要刪除？',
        showDenyButton: true,
        confirmButtonText: '刪除',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('product.delete'), { method: 'delete', data: { id: id } });
        }
      });
    },
  },
};
</script>

<template>
  <Head title="product" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        <Link :href="route('product.create')">
          <button type="button" class="font-semibold text-xl text-gray-800 leading-tight border border-black p-3 rounded-[6px]">新增商品</button>
        </Link>
      </div>
    </template>
    <section id="product" class="px-[15px] py-[10px] bg-white mt-[30px] rounded-[6px]">
      <table class="w-full">
        <thead>
          <tr>
            <th>#</th>
            <th>商品名稱</th>
            <th>商品價格</th>
            <th>公開/非公開</th>
            <th>建立時間</th>
            <th>商品描述</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in response.rt_data" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td>{{ item.name }}</td>
            <td>${{ item.price }}</td>
            <td v-if="item.public === 1">公開</td>
            <td v-else>非公開</td>
            <td>{{ item.timeFormat }}</td>
            <td>{{ item.desc }}</td>
            <td>
              <div>
                <Link :href="route('product.edit', { id: item.id })">
                  <button type="button" class="px-3 py-2 border border-black rounded-[5px]">編輯</button>
                </Link>
                <button type="button" class="px-3 py-2 border border-black bg-[red] rounded-[5px] text-white" @click="deleteProduct(item.id)">刪除</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product {
  table {
    th{
      @apply border border-black;
    }
    td {
      @apply text-center border border-black;
    }
  }
}
</style>
