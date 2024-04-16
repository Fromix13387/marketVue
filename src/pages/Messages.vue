<script setup>
import {ref} from "vue";
import {defaultUrl, User} from "../main.js";
import Messages from "../assets/js/Messages.js";
import { FlFilledSend  } from "@kalimahapps/vue-icons";
import messages from "../assets/js/Messages.js";

const message = ref('')




</script>

<template>
    <div class="Messages">
      <div class="users">
        <h1 v-if="Messages.users_message.length === 0">У вас пока нет ни с кем диалогов</h1>
        <div class="user" v-for="user of Messages.users_message">
          <img :src="defaultUrl + 'src/imageUser/' + (user.image ?? 'default.png')" alt="">
          <p>{{user.fullname}}</p>
        </div>
      </div>
      <div class="chat">
          <h1 v-if="Messages.receiver === 0">Выберите собеседника, чтобы увидеть диалог</h1>
          <h1 v-else-if="Messages.messages.length === 0">У вас пока нет диалога с этим пользователем</h1>
          <div v-else class="dialogs">

          </div>
          <div v-if="Messages.receiver !== 0" class="send-message">
            <input v-model="message"  placeholder="Напиши сообщение пользователю" />
            <button @click="Messages.send_message(messagec)"><FlFilledSend /></button>
          </div>

      </div>
    </div>
</template>

<style scoped lang="scss">
@import "../App";
  .Messages {
    padding:20px;
    width: 100%;
    display: grid;
    gap: 10px;
    height: 85vh;
    grid-template-columns: 30% 70%;
    .users, .chat {
      height: 100%;
      border: 1px solid $gray;
      border-radius: 10px;

      > h1 {
        font-size: 15px;
        color: $gray;
        letter-spacing: 2px;
        padding: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 70vh;
      }
    }
    .chat {

      position: relative;
      .send-message {
        position: absolute;
        padding: 20px;
        border-top: 1px solid $gray;
        border-radius:  0 0 9px 9px ;
        background-color: $bgColor;
        bottom: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        input {
          font-size: 15px;
          border: 1px solid $gray;
          background-color: rgba(255, 255, 255, 0.03);
          color: #c7c7c7;
          &::placeholder {
            padding: 0 1px;
            color: $gray
          }
          height: 40px;
          width: 100%;
          border-radius: 5px;
          padding: 5px 10px;
            outline: none;
        }
        button {
          cursor: pointer;
          border: none;
          background-color: transparent;
          svg {
            width: 20px;
            height: 20px;
            color: #e8e8e8;
          }
          &:hover svg {
            color: #b4b4b4;
          }
        }
      }
    }
    .users {
      display: flex;
      flex-direction: column;

      .user {
        display: flex;
        transition: background-color 0.2s ease;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding:5px 10px;
        position: relative;

        &:before {
          content: "";
          position: absolute;
          width: 100%;
          right: 0;
          bottom: 0;
          border-bottom: 1px solid $gray;
        }
        p {

        }
        img {
          width: 45px;
        }
        &:hover {
          background-color: rgba(218, 218, 218, 0.7);
        }
      }
    }
  }

</style>