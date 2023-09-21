<script>
export default {
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {

  },
  methods: {

  },
};
</script>

<template>
  <section id="frontend-index" class="max-w-7xl mx-auto">
    <h1 class="title">購物車</h1>
    <table class="w-full">
      <thead>
        <tr>
          <th>#</th>
          <th class="w-[200px]">商品圖片</th>
          <th>商品名稱</th>
          <th>商品價格</th>
          <th>購買數量</th>
          <th>金額</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in response?.rt_data ?? []" :key="item.id">
          <td>{{ index + 1 }}</td>
          <td>
            <img :src="item.product.img_path" alt="" class="w-[200px] aspect-[4/3] object-cover">
          </td>
          <td>{{ item.product.name }}</td>
          <td>{{ item.product.price }}</td>
          <td>{{ item.qty }}</td>
          <td>{{ item.product.price * item.qty }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }

  table {
    th, td {
      @apply border border-black text-center;
    }
  }
  .card{
    // @apply w-[calc(25%-22.5px)] border p-6;
  }
}
</style>
