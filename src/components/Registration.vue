<script setup>
import Modal from "./Modal.vue";
import {ref} from "vue";
import Message from "./Message.vue";
import {Fetch} from "../api/Fetch.js";

const username = ref('')
const fullname = ref('')
const email = ref('')
const password = ref('')
const password_confirm = ref('')

const visible = ref(false)
const text = ref('')
const type = ref('')

const setVisible = (data) => {
  text.value = data[0]
  type.value = data[1]
  visible.value = true
  setTimeout(() => visible.value = false,5000)
}
async function registration() {
  // if (!username.value) setVisible(['Имя пользователя не введено!', 'error'])
  // else if (!fullname.value) setVisible(['ФИО не введено!', 'error'])
  // else if (!email.value) setVisible(['Почта не введена!', 'error'])
  // else if (!password.value) setVisible(['Пароль не введён!', 'error'])
  // else if (password.value !== password_confirm.value) setVisible(['Пароли не совпадают', 'error'])
    let res = await Fetch({
      method: 'registration',
      username: username.value,
      fullname: fullname.value,
      email: email.value,
      password: password.value,
      password_confirm: password_confirm.value
    })
    if (res.error_code) setVisible([res.error_message, 'error'])
}


</script>

<template>
  <Modal>
      <div class="registration">
          <h2>Регистрация</h2>
          <div>
              <div> <input v-model="username" placeholder="Имя пользователя" type="text"></div>
              <div><input v-model="fullname" placeholder="ФИО"  type="text"></div>
              <div><input v-model="email" placeholder="Email" type="email"></div>
              <div><input v-model="password" placeholder="Пароль" type="password"></div>
              <div><input v-model="password_confirm" placeholder="Подтверждение пароля" type="password"></div>
          </div>
          <button @click="registration" >Зарегестрироваться</button>
      </div>
    <Message v-if="visible"  :text="text" :type="type"/>

  </Modal>

</template>


<style scoped lang="scss">
@import "../App";
.red {
  color: red
}
    .notice {
      position: absolute;
      top: 0;
      height: 50px;
      width: 100%;
    }
    .registration {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 20px;
        > div {
            display: flex;
            flex-direction: column;
            gap: 15px;
            > div {
                align-items: center;
                justify-content: space-between;
                display: flex;
                position: relative;
                gap: 10px;
                &::after {
                  content: "*";
                  color: red;
                  font-size: 18px;
                  position: absolute;
                  right: 5px;
                  top: 13px;
                }
                p {

                }
            }

        }
        input {
            width: 100%;
            height: 40px;
            border-radius: 10px;
            padding: 5px 15px;
            background-color: #c9c8c8;
            outline: none;
            border: none;
            position: relative;
            transition: all 0.15s ease;
            font-size: 15px;

            &:focus {
                background-color: #ffffff;
                box-shadow: 0 0 0 3px #2365c2;
            }

        }

        button {
            margin: 20px auto 0 auto;
            width: fit-content;
            padding: 8px 15px;
            background-color: $dopColor;
            border: none;
            color: white;
            font-size: 15px;
            border-radius: 10px;
            transition: background-color 0.3s ease, box-shadow 0.05s ease;
            cursor: pointer;
            &:hover {
                background-color: #f55050;
            }
            &:active {
                box-shadow: 0 0 5px white;
            }
        }

    }
</style>