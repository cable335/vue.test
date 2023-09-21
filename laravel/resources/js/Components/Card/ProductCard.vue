<script>
// import { router } from '@inertiajs/vue3';

export default {
  props: {
    productInfo: {
      type: Object,
      required: true,
      default: () => {
        return {};
      },
    },
    productTest: {
      type: String,
      required: false,
      default: () => {
        return '';
      },
    },
  },
  emits: ['addCart'],
  data() {
    return {
      num: 1,
    };
  },
  methods: {
    plus() {
      this.num++;
    },
    minus() {
      const { num } = this;
      if (num <= 1) return;
      this.num--;
    },
    inputNum() {
      const { num } = this;
      if (num <= 0) {
        this.num = 1;
      }
    },
    addCart() {
      const { num } = this;
      // const { productInfo, num } = this;
      // 寫法一：交給組件送資料
      // router.visit(route('product.addCart'), { method: 'post', data: { id: productInfo.id, qty: num } });
      // 寫法二：引入此組件的頁面去處理
      this.$emit('addCart', { qty: num });
    },
  },
};
</script>

<template>
  <section class="card">
    {{ productTest }}
    <img :src="productInfo.img_path" class="w-full aspect-[4/3] object-cover" alt="">
    <h3 class="name">商品名稱:{{ productInfo.name }}</h3>
    <h3 class="name">商品價格:${{ productInfo.price }}</h3>
    <h3 class="name">商品描述:{{ productInfo.desc }}</h3>
    <div class="flex justify-between items-stretch">
      <div class="flex items-center w-2/3 border border-black">
        <button type="button" class="grow text-center" @click="minus()">-</button>
        <input v-model="num" type="number" class="w-2/3 border-x-[1px] border-black border-y-0 outline-0 focus:ring-0 text-center" @change="inputNum()">
        <button type="button" class="grow text-center" @click="plus()">+</button>
      </div>
      <button type="button" class="w-1/3 border" @click="addCart()">加入購物車</button>
    </div>
  </section>
</template>

<style lang="scss" scoped>
  .card {
    @apply w-[calc(25%-22.5px)] border p-6;
  }
</style>
