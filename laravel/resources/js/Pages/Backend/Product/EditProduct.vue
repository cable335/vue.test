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
  data() {
    return {
      formData: {
        name: this.response?.rt_data?.name ?? '',
        price: this.response?.rt_data?.price ?? '',
        public: this.response?.rt_data?.public ?? '',
        desc: this.response?.rt_data?.desc ?? '',
      },
    };
  },
  methods: {
    submitData() {
      // 解析
      const { formData, response: { rt_data: { id } } } = this;
      // 驗證
      Swal.fire({
        title: `確認更新商品: ${ name }?`,
        showDenyButton: true,
        confirmButtonText: '更新',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('product.update'), { method: 'put', data: { formData, id },
            onSuccess: ({ props }) => {
              if (props.flash.message.rt_code === 1) {
                Swal.fire({
                  title: '更新成功',
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
        }
      });
    },
    inputClass(item) {
      if (!item) return '';
      return 'border-[red] rounded-[5px]';
    },
  },
};
</script>

<template>
  <Head title="product" />
  <AuthenticatedLayout>
    {{ $page.props.errors['formData.name'] ?? '' }}
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        <button type="button" class="font-semibold text-xl text-gray-800 leading-tight border border-black p-3 rounded-[6px]">編輯商品</button>
      </div>
    </template>
    <section id="product-create" class="px-[15px] py-[10px] bg-white mt-[30px] rounded-[6px]">
      <form @submit.prevent="submitData()">
        <label>
          商品名稱:
          <input v-model="formData.name" :class="{ 'border-[red]': $page.props.errors['formData.name'] }" type="text" name="name" required>
          <div class="text-[red]">{{ $page.props?.errors['formData.name'] ?? '' }}</div>
        </label>
        <input v-model="formData.image" type="hidden" min="0" required>
        <label>
          商品照片:
          <div class="relative w-[200px]">
            <div v-if="!formData.image" class="border w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer ">
              +
            </div>
            <input class="absolute top-1/2 left-1/2 translate-y-[10px] w-[1px] h-[1px] opacity-0" type="file" min="0" name="image" required @change="(event) => uploadImage(event)">
            <img v-if="formData.image" :src="formData.image" class="w-[200px] aspect-[4/3] object-cover" alt="上傳的照片">
          </div>
        </label>
        <label>
          商品價格:
          <input v-model="formData.price" :class="inputClass($page.props?.errors['formData.price'])" type="text" min="0" name="price" required>
          <div class="text-[red]">{{ $page.props?.errors['formData.price'] ?? '' }}</div>
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
          <input v-model="formData.desc" type="text" name="desc" :class="inputClass($page.props?.errors['formData.desc'])">
        </label>
        <div class="flex justify-center items-center gap-[45px]">
          <button type="submit">更新</button>
          <Link :href="route('product.list')">
            <button type="button">取消</button>
          </Link>
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
