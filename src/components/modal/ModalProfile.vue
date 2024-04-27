<script setup>

import {AdminPath, User} from "../../main.js";
import {Fetch} from "../../api/Fetch.js";
import {useRouter} from "vue-router";
const emit = defineEmits(['close'])

const router = useRouter()
async function exit() {
  const res = await Fetch({method: 'exit'})

  if (res.answer === true) {
    emit('close')
    User.auth = false
    if (AdminPath.includes(router.currentRoute.value.fullPath)) await router.push('/')
  }

}
</script>

<template>
  <div class="modalProfile">
    <p class="username">{{User.username}}</p>
    <hr>
    <div class="profile-content">
      <router-link @click="emit('close')" to="/MyProfile">Мой профиль</router-link>
<!--      <router-link @click="emit('close')" to="/Messages">Сообщения</router-link>-->
      <router-link @click="emit('close')" to="/Basket">Корзина</router-link>
      <router-link v-if="User.role >= 2" @click="emit('close')" to="/AdminPanel/users">Админка</router-link>
      <router-link @click="emit('close')" to="/HistoryBuy">История покупок</router-link>
    </div>
    <hr>
    <div class="profile-content">
      <router-link class="exit" to="" @click="exit">Выйти</router-link>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "../../App";

  .modalProfile {
    cursor: auto;
    position: absolute;
    background-color: #314669;
    max-height: 300px;
    border-radius: 10px;
    width: 200px;
    right:   0;
    overflow: hidden;
    top: 55px;
    display: flex;
    flex-direction: column;
    .username {
      text-transform: uppercase;
      padding: 5px 0;
      font-size: 11px;
      letter-spacing: 2px;
      text-align: center;
    }
    .profile-content {
      padding: 3px 0;
      font-size: 15px;
      color: #e8e7e7;
      display: flex;
      flex-direction: column;
      > a {
        text-decoration: none;
        transition: background-color 0.2s ease;
        cursor: pointer;
        padding: 7px 15px;
        border-radius: 5px;
        font-family: Candara !important;

        &:hover {
          background-color: rgba(176, 176, 176, 0.2);
        }
      }
    }
    hr {
      width: 100%;
      border: none;
      border-bottom: 2px solid $dopColor;
    }
    .exit {
      margin: auto;
    }

  }
@media (width < 400px) {
  .modalProfile {
    right:  50% !important;
    transform: translateX(50%)
  }
}

</style>