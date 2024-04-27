<script setup>
import { BxVk, BxTelegram, BxFacebook} from "@kalimahapps/vue-icons";
</script>

<template>
<div class="Footer">
  <div class="link">
    <img src="../assets/icons/printer-logo.png" alt="">
    <div class="pages">
      <router-link to="/Catalog">Каталог</router-link>
      <router-link to="/Contact">На карте</router-link>

    </div>
    <div class="pages">
      <router-link to="/About">О нас</router-link>
      <router-link to="/Rules">Правила сайта и политика конфиденциальности</router-link>
    </div>
  </div>

  <div class="icons">
    <a target="_blank" href="https://vk.com/fromix13387"><BxVk/></a>
    <a target="_blank" href="https://t.me/Fromix13387"><BxTelegram/></a>
    <a target="_blank" href="https://facebook.com"><BxFacebook/></a>
  </div>
</div>
</template>

<style scoped lang="scss">
@import "../App";
.Footer {
  margin-top: 50px;
  background-color: $bgColor;
  width: 100%;
  padding: 50px 15px 20px 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
  .icons {
    margin-top: 30px;
    display: flex;
    gap: 35px;
    font-size: 50px;
    a svg {
      transition: color 0.5s ease;
    }
    a:hover svg {
      color: white;
    }
  }
  .link {
    display: flex;
    justify-content: space-between;
    width: 95%;
    max-width: 1200px;
    align-items: center;
    font-size: 15px;
    > img {
      width: 100%;
      max-width: 100px;
    }
    > div {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    a {
      transition: color 0.5s ease;
      font-size: 17px;
      &:hover {
        color: white;
      }
    }
  }
  * {
    color: #bbb9b9;
  }
}
</style>