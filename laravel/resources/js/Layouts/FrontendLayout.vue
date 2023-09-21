<script>
import { router } from '@inertiajs/vue3';

export default {
  methods: {
    logout() {
      router.post(route('logout'));
    },
  },
};
</script>

<template>
  <section id="frontend-layout">
    <header id="header">
      <div v-if="!$page.props.auth.user" class="flex justify-end gap-5 mb-5">
        <Link :href="route('register')" class="btn-base">註冊</Link>
        <Link :href="route('dashboard')" class="btn-base">登入</Link>
      </div>
      <div v-else class="flex justify-end gap-5 mb-5">
        <Link :href="route('user.cart')">我的購物車</Link>
        <button type="button" class="btn-base" @click="logout()">登出</button>
      </div>
    </header>
    <main id="main">
      <slot />
    </main>
    <footer id="footer"></footer>
  </section>
</template>

<style lang="scss" scoped>
#frontend-layout {
  @apply w-full min-h-screen;
}

#main {
  @apply min-h-[calc(100dvh-42px)];
}

#header, #footer {
  @apply h-[21px] bg-[#00bd89];
}
</style>
