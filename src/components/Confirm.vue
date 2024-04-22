<script setup>

import Modal from "./modal/Modal.vue";
import Button from "./Button.vue";
import {ref} from "vue";
import {Fetch} from "../api/Fetch.js";
import Message from "./Message.vue";
import basket from "../assets/js/Basket.js";

const password = ref('')
const props = defineProps({
  checkConfirm: Function
})
const visibleMessage = ref(false)
const text = ref({text: '', type: ''})
const confirm = async () => {
  const res = await Fetch({method: 'checkPassword', password:password.value})
  if (res.password) {
    basket.filterObject().map( async el =>  {
      const res = await Fetch({method: 'saveOrder', id_product: el.id, count: basket.getCountProduct(el.id)
    })})

    text.value = {text: 'Успешно', type: 'success'}
    visibleMessage.value = true
    props.checkConfirm()
  }
  else {
    text.value = {text: 'Пароль не верный', type: 'error'}
    visibleMessage.value = true
  }
}
</script>

<template>
  <Modal>
    <div class="confirm">
      <h3>Подтверждение заказа</h3>
      <div>
        <p>Введите пароль: </p>
        <input v-model="password" placeholder="password" class="inp" type="password">
      </div>

      <Button @click="confirm">Подтвердить</Button>
    </div>
    <Message :visible="visibleMessage" :text="text.text" :type="text.type"/>
  </Modal>
</template>

<style scoped lang="scss">
@import "../App";
.confirm {
  h3 {
    text-align: center;
  }
  > div {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  input {
    height: 30px;
    border-radius: 10px;
    padding: 5px 15px;
    background-color: #c9c8c8;
    outline: none;
    border: none;
    transition: all 0.15s ease;
    font-size: 15px;
    &:focus {
      background-color: #ffffff;
      box-shadow: 0 0 0 1px $dopColor;
    }
  }
  display: flex;
  flex-direction: column;
  gap: 15px;
  color: white;
  padding: 15px;
}
</style>