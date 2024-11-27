<template>
  <Exchange />
</template>
<script setup>
import apiClient from "@/configs/axios.js";
import {onMounted} from "vue";
import Exchange from "@/components/Exchange.vue";

onMounted(async () => {
  // console.log(await apiClient.get('currencies/you-give'));
})
</script>

<style lang="scss">
  html, body {
    height: 100%;
  }
  #app {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
