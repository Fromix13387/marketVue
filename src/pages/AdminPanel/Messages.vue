<script setup>

import Button from "../../components/Button.vue";
import { ReDeleteBinLine } from "@kalimahapps/vue-icons";
import {Fetch} from "../../api/Fetch.js";
import {onMounted, ref} from "vue";

const data = ref([])
const deleteMessage = async (id) => {
  const res = await Fetch({method: 'deleteMessage', id: id})
  if (res) data.value = data.value.filter(el => el.id !== id)
}
onMounted( async() => {
  data.value = await Fetch({method: 'getMessagesAll'})
})
</script>

<template>
  <div class="Messages">
    <div class="table">
      <table>
        <tr>
          <th>Номер</th>
          <th>Имя заказчика</th>
          <th>Почта</th>
          <th>Сообщение</th>
          <th>Время отправления</th>
          <th>Действия</th>
        </tr>
        <tr v-for="el of data" :key="el.id">
          <td>{{el.id}}</td>
          <td>{{el.last_name}} {{el.first_name}}</td>
          <td>{{el.email}}</td>
          <td>{{el.text}}</td>
          <td>{{el.date}}</td>
          <td class="button"><Button @click="deleteMessage(el.id)" class="red"><ReDeleteBinLine/></Button></td>
        </tr>
      </table>
    </div>

  </div>
</template>

<style scoped lang="scss">
@import "../../App";
.Messages {
  .table {
    @include table;
  }
}
</style>