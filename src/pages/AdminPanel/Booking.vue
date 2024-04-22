<script setup>

import { ReDeleteBinLine } from "@kalimahapps/vue-icons";
import {onMounted, ref} from "vue";
import {Fetch} from "../../api/Fetch.js";
import Button from "../../components/Button.vue";

const data = ref([])


const deleteRecording = async (id) => {
  const res = await Fetch({method: 'deleteBookingDate', id_booking: id})
  if (res) data.value = data.value.filter(el => el.id !== id)
}

onMounted( async() => {
  data.value = await Fetch({method: 'getBookingAll'})
})

</script>

<template>
  <div class="Booking">
    <div class="table">
      <table>
        <tr>
          <th>Номер</th>
          <th>Имя заказчика</th>
          <th>Телефон</th>
          <th>Почта</th>
          <th>Кол-во игроков</th>
          <th>Цена</th>
          <th>Дата</th>
          <th>Время</th>
          <th>id квеста</th>
          <th>Дата оформления</th>
          <th>Действия</th>
        </tr>
        <tr v-for="el of data" :key="el.id">
          <td>{{el.id}}</td>
          <td>{{el.last_name}} {{el.first_name}}</td>
          <td>{{el.phone}}</td>
          <td>{{el.email}}</td>
          <td>{{el.players}}</td>
          <td>{{el.cost}}</td>
          <td>{{el.date}}</td>
          <td>{{el.time}}</td>
          <td>{{el.id_quest}}</td>
          <td>{{el.booking_at}}</td>
          <td class="button"><Button @click="deleteRecording(el.id)" class="red"><ReDeleteBinLine/></Button></td>
        </tr>
      </table>
    </div>

  </div>
</template>

<style scoped lang="scss">
@import "../../App";
  .Booking {
    .table {
      @include table;
    }
  }
</style>