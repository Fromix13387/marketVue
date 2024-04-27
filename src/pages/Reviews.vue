<script setup>

import Button from "../components/Button.vue";
import {onMounted, ref} from "vue";
import {Fetch} from "../api/Fetch.js";
import {User} from "../main.js";
import moment from 'moment'
const title = ref('')
const value = ref('')

const data = ref([])
const sendReviews = async () => {
  const res = await Fetch({method: 'sendReviews', title: title.value, value: value.value})
  if (res) {
    data.value.unshift({username: User.username, image: User.image, title: title.value, value: value.value, date: moment().format( "YYYY-MM-DD hh:mm:ss")})
    title.value = ''
    value.value = ''
  }
}
onMounted(async() => {
  data.value = await Fetch({method: 'getReviews'})
})
</script>

<template>
  <div class="Reviews">
    <div class="feedback">
        <input v-model="title" type="text" placeholder="Заголовок отзыва">
        <textarea v-model="value" placeholder="Ваш коментарий" ></textarea>
        <Button @click="sendReviews" :disabled="title === '' || value === ''">Опубликовать</Button>
    </div>
    <div class="reviews">
      <div v-for="el of data">
        <div class="user">
          <img :src="'Server/src/imageUser/' + el.image" alt="">
          <p>{{el.username}}</p>
        </div>
        <div class="info">
          <div>
            <h2>{{el.title}}</h2>
            <p>{{el.date}}</p>
          </div>
          <p>{{el.value}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "../App";
  .Reviews {
    @include main;
    .feedback {
      padding: 15px;
      border-radius: 15px;
      display: flex;
      box-shadow: 0 0 5px #646464;;
      align-items: center;
      flex-direction: column;
      gap: 15px;

      > input, textarea {
        @include input;
        background-color: rgba(220, 204, 205, 0.51);
        &:focus {
          box-shadow:0 0 0 1px $bgColor;
        }
      }
      button {
        height: 40px;
        font-size: 18px;
        letter-spacing: 1px;
        margin: 0;
        width: 250px  ;
        &:disabled {
          opacity: 0.5;
          pointer-events: none;
        }
      }
      textarea {
        padding: 15px;
        height: 150px;
      }
    }
    .reviews {
      display: flex;
      flex-direction: column;
      gap: 25px;
      > div {
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 0 5px #646464;
        display: flex;
        gap: 15px;
        .user {
          img {
            max-width: 150px;
            border-radius: 50%;
          }
          p {
            font-weight: bold;
            font-size: 18px;
            text-align: center;
          }
        }
        .info {
          width: 100%;
          display: flex;
          flex-direction: column;
          gap: 15px;
          > div {
            display: flex;
            justify-content: space-between;
          }
        }
        //.user {
        //  display: flex;
        //  flex-direction: column;
        //  gap: 5px;
        //}
      }
    }
  }

</style>