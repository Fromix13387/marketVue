<script setup>
import vSelect from "vue-select";
import Button from "../../components/Button.vue";
import { ReDeleteBinLine } from "@kalimahapps/vue-icons";
import {Fetch} from "../../api/Fetch.js";
import {onMounted, ref} from "vue";

const data = ref([])
const statuses = ref([])
const deleteOrder = async (id) => {
  const res = await Fetch({method: 'deleteOrder', id: id})
  if (res) data.value = data.value.filter(el => el.order_id !== id)
}

const changeStatus = async (el) => {
  console.log(el)
  const res = await Fetch({method: 'changeStatus', status_id: el.selected_status.id, user_id: el.user_id,
    order_id: el.order_id
  })
}
onMounted( async() => {
  data.value = await Fetch({method: 'getOrders'}).then(res => res.map(el => {
    return {...el,selected_status: {nameStatus: el.nameStatus, id: el.status_id, user_id: el.user_id}}
  }))
  statuses.value = await Fetch({method: 'getStatuses'})
  console.log(data.value)
})
</script>

<template>
  <div class="Orders">
    <div class="table">
      <table>
        <tr>
          <th>Номер</th>
          <th>Имя заказчика</th>
          <th>Название товара</th>
          <th>Фото</th>
          <th>Стоимость</th>
          <th>Количество</th>
          <th>Статус</th>
          <th>Действия</th>
        </tr>
        <tr v-for="el of data" :key="el.id">
          <td>{{el.order_id}}</td>
          <td>{{el.fullname}}</td>
          <td>{{el.nameProduct}}</td>
          <td><img :src="'Server/src/product/' + el.image" alt=""></td>
          <td>{{el.price*el.count}} ₽</td>
          <td>{{el.count}} шт</td>
<!--          <td>{{el.nameStatus}}</td>-->
          <td>
            <vSelect @option:selected="changeStatus(el)"  v-model="el.selected_status" placeholder="Ничего не выбрано"  :options="statuses" label="nameStatus" code="id">
              <template #no-options='option'>Значение не найдено</template>
              <template #selected-option="{ id, nameStatus }">{{nameStatus}}</template>
            </vSelect>
          </td>
          <td class="button"><Button @click="deleteOrder(el.order_id)" class="red"><ReDeleteBinLine/></Button></td>
        </tr>
      </table>
    </div>

  </div>
</template>
<style>
.Orders {
  .v-select {
    width: 200px;
    margin: auto;
  }
  .vs__dropdown-menu {
    background-color: rgba(45, 45, 45, 0.38) !important;
    .vs__dropdown-option {
      color: black;
    }
    .vs__dropdown-option--highlight {
      background-color: rgba(0, 0, 0, 0.22);
    }
  }
}
</style>
<style scoped lang="scss">
@import "../../App";
.Orders {
  .table {
    @include table;
    img {
      width: 150px;
    }
    td {
      > * {
        vertical-align: middle;
        color: white;
      }
      span {
        padding-left: 3px ;
      }
      max-width: 200px;
    }
    }

}
</style>