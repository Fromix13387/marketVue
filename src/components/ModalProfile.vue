<script setup>

import {User} from "../main.js";
import {Fetch} from "../api/Fetch.js";
const emit = defineEmits(['close'])


async function exit() {
  const res = await Fetch({method: 'exit'})
  console.log(res)
  if (res.answer === true) User.value = {auth: false}

}
</script>

<template>
  <div @click.stop.prevent class="modalProfile">
    <p class="username">{{User.username}}</p>
    <hr>
    <div class="profile-content">

      <router-link @click="emit('close')" to="">Мой профиль</router-link>
      <router-link @click="emit('close')" to="">Настройки профиля</router-link>
      <router-link @click="emit('close')" to="/Basket">Корзина</router-link>
      <router-link @click="emit('close')" to="">История покупок</router-link>
    </div>
    <hr>
    <div class="profile-content">
      <router-link to="" @click="exit">Выйти</router-link>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "../App";

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
    align-items: center;
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

  }
@media (width < 400px) {
  .modalProfile {
    right:  50% !important;
    transform: translateX(50%)
  }
}

</style>