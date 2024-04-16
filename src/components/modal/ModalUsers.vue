<script setup>
import Messages from "../../assets/js/Messages.js";
import {defaultUrl, User} from "../../main.js";

</script>

<template>
  <transition name="ModalUsers">
    <div v-if="Messages.visibleModal" class="ModalUsers" >
      <div class="users">
        <div class="user" v-for="user of Messages.users" @click="Messages.getMessages(User,user)">
          <img :src="defaultUrl + 'src/imageUser/' + (user.image ?? 'default.png')" alt="">
          <p>{{user.fullname}}</p>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped lang="scss">
@import "../../App";
  .ModalUsers {
    position: absolute;
    top: 50px;
    height: 200px;
    border-radius: 3px 3px 10px 10px;
    min-width: 250px;
    background-color: $bgColor;
    overflow-y: auto;
    &::-webkit-scrollbar {
      width: 5px;
    }
    &::-webkit-scrollbar-thumb {
      background: linear-gradient(45deg, #e5a2a2, #bdbff6);
      border-radius: 20px;
    }
    .users {
      display: flex;
      flex-direction: column;
      gap: 10px;
      padding: 5px;
      .user {
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        border-radius: 10px;
        padding: 5px 10px;

        img {
          width: 35px;
        }
        &:hover {
          background-color: rgba(255, 255, 255, 0.2);
        }
      }
    }
  }

.ModalUsers-enter-active {
  animation: modalProfile 0.3s;
}
.ModalUsers-leave-active {
  animation: modalProfile .3s reverse;
}

@keyframes modalProfile {
  from {
    max-height: 0;
  }
  to {
    max-height: 200px;
  }
}
</style>