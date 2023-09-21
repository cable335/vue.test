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
        image: '',
        otherImage: [
        ],
        price: '',
        public: '',
        desc: '',
      },
      imageSize: 0,
    };
  },
  methods: {
    submitData() {
      const { formData } = this;
      if (this.imageSize > 3145728) return Swal.fire('圖片檔案過大');
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
    uploadImage(event) {
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        console.log(reader.result);
        this.formData.image = reader.result;
        this.imageSize += event.target.files[0].size;
      };
      reader.onerror = (error) => {
        console.log('Error: ', error);
      };
    },
    uploadOtherImage(event) {
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        this.formData.otherImage.push({
          id: Math.max(0, ...this.formData.otherImage.map(item => item.id)) + 1,
          img_path: reader.result,
          size: event.target.files[0].size,
        });
        this.imageSize += event.target.files[0].size;
      };
    },
    removeImage(id) {
      this.imageSize -= this.formData.otherImage.find((item) => item.id === id).size;
      this.formData.otherImage = this.formData.otherImage.filter((item) => item.id !== id);
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
          商品照片:
          <div class="relative w-[200px]">
            <div v-if="!formData.image" class="border w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer ">
              +
            </div>
            <input class="absolute top-1/2 left-1/2 translate-y-[10px] w-[1px] h-[1px] opacity-0" type="file" min="0" name="image" required @change="(event) => uploadImage(event)">
            <img v-if="formData.image" :src="formData.image" class="w-[200px] aspect-[4/3] object-cover" alt="上傳的照片">
          </div>
        </label>
        其他照片:
        <div class="flex flex-wrap gap-[30px]">
          <div v-for="item in formData.otherImage" :key="item.id" class="relative">
            <img :src="item.img_path" class="border w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer " alt="">
            <button type="button" class="rounded-full w-[20px] h-[20px] flex justify-center items-center bg-[red] text-white absolute top-0 right-0 translate-x-1/2 -translate-y-1/2" @click="removeImage(item.id)"></button>
          </div>
          <label class="border w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer ">
            +
            <input type="file" class="hidden" @change="(event) => uploadOtherImage(event)">
          </label>
        </div>
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
          <button type="submit">確認</button>
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
