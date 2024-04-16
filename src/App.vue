<script setup>

import Header from "./components/Header.vue";

</script>

<template>
    <Header/>
    <div class="main" >
        <router-view></router-view>
    </div>
    <div class="footer">
        <p>+7 (495) 123-45-67</p>
        <p>г. Челябинск, ул. Гагарина, д. 7</p>
        <p>info@mail.ru</p>
    </div>
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
.footer {
  flex-wrap: wrap;
  gap: 15px;
  padding: 15px;
    color: white;
    background-color: $bgColor;
    display: flex;
    justify-content: space-around;
    align-items: center;
    min-height: 70px;
}
</style>
