<script setup>

import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

</script>

<template>
    <Header/>
    <div class="main" >
        <router-view></router-view>
    </div>
    <Footer/>
</template>

<style scoped lang="scss">
@import "App";
.main {
    display: flex;
    flex-direction: column;
    gap: 40px;
    align-items: center;
    min-height: 85vh;
}

</style>
