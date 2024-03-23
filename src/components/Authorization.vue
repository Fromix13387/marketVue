<script setup>
import Modal from "./Modal.vue";
import {ref, watchEffect} from "vue";
import Message from "./Message.vue";
import {Fetch} from "../api/Fetch.js";
import {User, visibleModal} from "../main.js";
import Button from "./Button.vue";
const visible = ref(false)
const username = ref('')
const password = ref('')

const text = ref('')
const type = ref('')

const setVisible = (data) => {
  text.value = data[0]
  type.value = data[1]
  visible.value = true
  setTimeout(() => visible.value = false,20000)
}
async function authorization() {
  const res = await Fetch({
    method: 'authorization',
    username: username.value,
    password: password.value
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
        <div class="authorization"  @keyup.enter="authorization">
            <h2>Авторизация</h2>
            <div>
                <input v-model="username" placeholder="Имя пользователя" type="text">
                <input v-model="password" placeholder="Пароль" type="password">
            </div>

            <div class="sign"><Button @click="authorization">Войти</Button></div>
            <p @click="visibleModal = 'registration'"  class="reg">Регистрация</p>
        </div>
        <Message :visible="visible" :text="text" :type="type"/>
    </Modal>
</template>

<style scoped lang="scss">
@import "../App";

.sign {
  width: 100%;
  align-items: center;
}
.authorization {
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
            gap: 10px;

            p {

            }
        }

    }
    input {
        height: 40px;
        border-radius: 10px;
        padding: 5px 15px;
        background-color: #c9c8c8;
        outline: none;
        border: none;
        transition: all 0.15s ease;
        font-size: 15px;
        &:focus {
            background-color: #ffffff;
            box-shadow: 0 0 0 3px #2365c2;
        }
    }
    //button {
    //    width: fit-content;
    //    padding: 8px 35px;
    //    background-color: $dopColor;
    //    border: none;
    //    color: white;
    //    font-size: 15px;
    //    border-radius: 10px;
    //    transition: background-color 0.3s ease, box-shadow 0.05s ease;
    //    cursor: pointer;
    //    &:hover {
    //        background-color: #f55050;
    //    }
    //    &:active {
    //        box-shadow: 0 0 5px white;
    //    }
    //}

}
</style>