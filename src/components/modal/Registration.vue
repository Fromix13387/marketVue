<script setup>
import Modal from "./Modal.vue";
import {ref} from "vue";
import Message from "../Message.vue";
import {Fetch} from "../../api/Fetch.js";
import {User, visibleModal} from "../../main.js";
import Button from "../Button.vue";

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
  setTimeout(() => visible.value = false,20000)
}
async function registration() {
    const res = await Fetch({
      method: 'registration',
      username: username.value,
      fullname: fullname.value,
      email: email.value,
      password: password.value,
      password_confirm: password_confirm.value
    })
    if (res.error_code) return setVisible([res.error_message, 'error'])
    localStorage.setItem('token', res.token)
    User.value = {...res, auth: true}
    visibleModal.value = ''
    setVisible([res.message, 'success'])
}


</script>

<template>
  <Modal>
      <div class="registration" @keyup.enter="registration">
          <h2>Регистрация</h2>
          <div>
              <div> <input v-model="username" placeholder="Имя пользователя" type="text"></div>
              <div><input v-model="fullname" placeholder="ФИО"  type="text"></div>
              <div><input v-model="email" placeholder="Email" type="email"></div>
              <div><input v-model="password" placeholder="Пароль" type="password"></div>
              <div><input v-model="password_confirm" placeholder="Подтверждение пароля" type="password"></div>
          </div>
        <Button   @click="registration">Зарегестрироваться</Button>
          <p @click="visibleModal = 'authorization'"  class="auth">Войти</p>
      </div>
    <Message :visible="visible"  :text="text" :type="type"/>

  </Modal>

</template>


<style scoped lang="scss">
@import "../../App";
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
        padding: 35px;
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
            @include input;

        }
    }
</style>