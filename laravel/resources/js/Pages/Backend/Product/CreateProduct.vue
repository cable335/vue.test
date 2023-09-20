<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  data() {
    return {
      formData: {
        name: '',
        price: '',
        public: '',
        desc: '',
      },
    };
  },
  methods: {
    submitData() {
      const { formData } = this;
      // 驗證
      router.visit(route('product.store'), { method: 'post', data: formData,
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '新增成功',
              showDenyButton: true,
              confirmButtonText: '回列表',
              denyButtonText: '取消',
            }).then((result) => {
              if (result.isConfirmed) {
                router.get(route('product.list'));
              }
            });
          }
        },
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
        <button type="button" class="font-semibold text-xl text-gray-800 leading-tight border border-black p-3 rounded-[6px]">新增商品</button>
      </div>
    </template>
    <section id="product-create" class="px-[15px] py-[10px] bg-white mt-[30px] rounded-[6px]">
      <form @submit.prevent="submitData()">
        <label>
          商品名稱:
          <input v-model="formData.name" type="text" name="name" required>
        </label>
        <label>
          商品價格:
          <input v-model="formData.price" type="text" min="0" name="price" required>
        </label>
        公開/非公開:
        <div class="flex items-center gap-[10px]">
          <label>
            <input v-model="formData.public" name="public" type="radio" value="1" required>
            公開
          </label>
          <label>
            <input v-model="formData.public" name="public" type="radio" value="2" required>
          </label>
          非公開
        </div>
        <label>
          商品描述:
          <input v-model="formData.desc" type="text" name="desc">
        </label>
        <div class="flex justify-center items-center gap-[45px]">
          <button class="" type="submit">確認</button>
          <button type="button">取消</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
  form {
    @apply flex flex-col gap-[10px];
    .btn{
      @apply border border-[gray] bg-[gray] font-bold px-[15px] py-[10px] rounded-[5px];
    }
  }
}
</style>