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
    return {
      title: 'Hello World !',
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="frontend-index" class="max-w-7xl mx-auto">
    <h1 class="title">{{ title }}</h1>
    <div class="flex justify-center gap-5 mb-5">
      <Link :href="route('register')" class="btn-base">註冊</Link>
      <Link :href="route('dashboard')" class="btn-base">登入</Link>
    </div>
    <div class="flex gap-[30px] flex-wrap">
      <div v-for="item in response.rt_data ?? []" :key="item.id" class="card">
        <h3 class="name">商品名稱:{{ item.name }}</h3>
        <h3 class="name">商品價格:{{ item.price }}</h3>
        <h3 class="name">商品描述:{{ item.desc }}</h3>
      </div>
    </div>
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

  .card{
    @apply w-[calc(25%-22.5px)] border p-6;
  }
}
</style>
