<template>
<div class="box-sizing">
  <DefaultHeader></DefaultHeader>
  <section class="flex w-full">
    <DefaultNavigation></DefaultNavigation>
    <Nuxt />
  </section>
</div>
</template>
<script>
import DefaultHeader from "../components/Header/DefaultHeader.vue"
import DefaultNavigation from "../components/Navigation/DefaultNavigation.vue"
export default {
  name: 'layoutDefault',
  components:{DefaultHeader,DefaultNavigation}
}
</script>
