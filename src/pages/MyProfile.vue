<script setup>
import { MaskInput } from 'vue-3-mask';
import {onMounted, reactive, ref, watchEffect} from "vue";
import {Fetch} from "../api/Fetch.js";
import Button from "../components/Button.vue";
import {User, visibleModal} from "../main.js";
import { MdOutlinedPhotoCamera } from "@kalimahapps/vue-icons";

const username = ref('')
const fullname = ref('')
const email = ref('')
const password = ref('')
const password_confirm = ref('')
const image = ref('')
const img = ref('')

const notice = reactive({text: '', type: 'error'})

watchEffect(() => {
  console.log(User)
  username.value = User.username
  fullname.value = User.fullname
  email.value = User.email
  img.value = 'Server/src/imageUser/'+(User.image ?? 'default.png')
})

async function changeProfile() {
  const res = await Fetch({
    method: 'changeProfile',
    username: username.value,
    fullname: fullname.value,
    image: image.value,
    email: email.value,
    password: password.value,
    password_confirm: password_confirm.value
  })
  if (res.error_code) {
    notice.type = 'error'
    return notice.text = res.error_message
  }


  localStorage.setItem('token', res.token)
  for (const key in res) User[key] = res[key]
  User.auth = true
  notice.text = res.message;
  return notice.type = 'success'
}
const uploadFile = (event) => {
  image.value = event.target.files[0]
  if (!FileReader) {
    alert('FileReader не поддерживается — облом');
    return;
  }
  const fileReader = new FileReader();
  fileReader.onload = function() {
    img.value = fileReader.result;
  }
  fileReader.readAsDataURL(event.target.files[0]);
}

const hoverPhoto = ref(false)
</script>

<template>
<div class="myProfile">
  <h2>Мой профиль</h2>
  <div class="content-modal">
    <div @mouseenter="hoverPhoto = true" @mouseleave="hoverPhoto = false" class="img">
      <img  :src="img" alt="">
      <MdOutlinedPhotoCamera class="icon" v-show="hoverPhoto"/>
      <input class="file" @change="uploadFile" type="file"/>
    </div>
   <div class="data">
     <h3>Основные данные</h3>
     <p @click="notice.text = ''" :class="[{success: notice.type === 'success'}, 'notice']" v-if="notice.text !== ''">{{notice.text}}</p>
     <div class="form">
       <MaskInput :value="username"  mask="SSSSSSSSSSSSSSSSS" v-model= "username" type="text" placeholder="Ваш ник"/>
       <input v-model="fullname" type="text" placeholder="ФИО"/>
       <input  v-model="email" type="email" placeholder="Почта"/>

     </div>
     <h3>Смена пароля</h3>
     <div class="form">
       <input v-model="password" placeholder="Пароль" type="password">
       <input v-model="password_confirm" placeholder="Подтверждение пароля" type="password">
     </div>
     <Button  @click="changeProfile" :disabled="username === '' || fullname === '' || email === ''">Сохранить</Button>
   </div>
  </div>
</div>
</template>

<style scoped lang="scss">
  @import "../App";
  .myProfile {
    margin-top: 35px;
    width: 80%;
    display: flex;
    flex-direction: column;
    gap: 25px;

    .content-modal {
      justify-content: space-between;
      display: flex;
      flex-direction: row;
      width: 100%;
      gap: 20px;
      align-items: start;

      .img {
        position: relative;
        max-width: 340px;

        width: 40%;
        @include profileImg;

      }
      > div.data {
        width: 70%;
        display: flex;
        flex-direction: column;
        gap: 15px;
      }
    }

    .notice {
      @include notice;

      &.success {
        color: greenyellow;
      }
    }

      .form {
        display: flex;
        //flex-direction: column;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 15px;

        input {
          @include input
        }
      }

      button {
        width: 50%;
        min-width: 200px;
        margin: 0 auto;
        &:disabled {
          pointer-events: none;
          opacity: 0.5;
        }
      }
    }
  @media (width < 860px) {
    .myProfile {
      width: 95%;
    }
  }
  @media (width < 650px) {
    .myProfile {
      .content-modal {
        flex-direction: column;
        align-items: center;
        > div  {
          width: 100% !important;
        }
      }
    }
  }
</style>