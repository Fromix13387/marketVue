<script setup>

import {User} from "../../main.js";
import {onMounted} from "vue";
import {useRouter} from "vue-router";

const router = useRouter()
onMounted(() => {
  if (User.role < 2) router.push('/')
})
</script>

<template>
  <div v-if="User.role > 1" class="AdminPanel">
    <div class="tabs">
      <router-link to="/AdminPanel/users">Все пользователи</router-link>
      <router-link to="/AdminPanel/products">Все продукты</router-link>
      <router-link to="/AdminPanel/countries">Все страны</router-link>
      <router-link to="/AdminPanel/categories">Все категории</router-link>
      <router-link to="/AdminPanel/orders">Заявки</router-link>
    </div>
    <div class="data">
      <h2>Панель администратора</h2>
      <hr>
      <router-view/>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "../../App";
  .AdminPanel {
    display: flex;
    gap: 15px;
    width: 95%;
    margin-top: 25px;
    .tabs {
      background-color: $bgColor;
      border-radius: 15px;
      padding: 25px;
      display: flex;
      flex-direction: column;

      gap: 10px;
      a {
        letter-spacing: 1px;
        white-space: nowrap;
        color: white;
        &.router-link-active {
          color: white;
          text-decoration: underline;
        }
        &:hover {
          text-decoration: underline;
        }
      }
    }
      .data {
        overflow: hidden;
        width: fit-content;
        display: flex;
        flex-direction: column;
        gap: 15px;
        hr {
          height: 2px;
          background-color: black;
          border: none;
        }
      }
  }
@media (width < 850px) {
  .AdminPanel {
    flex-wrap: wrap;
  }
}
</style>