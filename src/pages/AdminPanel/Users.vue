<script setup>

import Button from "../../components/Button.vue";
import ModalEditUser from "../../components/modal/ModalEditUser.vue";
import {onMounted, ref} from "vue";
import {Fetch} from "../../api/Fetch.js";
import { ReDeleteBinLine, ClEditPencil01  } from "@kalimahapps/vue-icons";
import {User} from "../../main.js";

const data = ref([])

const modalEditUser = ref(false)
const EditUser = ref({})
const changeUser = (fullname, email, image,{id, name_role}) => {
  data.value = data.value.map(user => {
    if (user.id === EditUser.value.id) {
      user.fullname = fullname
      user.email = email
      user.image = image
      user.role = id
      user.name_role = name_role
    }
    return user
  })
  modalEditUser.value = false
}
const editUser = (user) => {
  EditUser.value = user
  modalEditUser.value = true
}

const deleteUser = async (id) => {
  const res = await Fetch({method: 'deleteUser', id})
  if (res) data.value = data.value.filter(el => el.id !== id)
}

onMounted( async() => {
  data.value = await Fetch({method: 'getUsers'})
})
</script>

<template>
  <div class="Users">
    <div class="table">
      <table>
        <tr>
          <th>Номер</th>
          <th>Никнейм</th>
          <th>Имя пользователя</th>
          <th>Почта</th>
          <th>Роль</th>
          <th>Аватарка</th>
          <th>Дата регистрации</th>
          <th>Действия</th>
        </tr>
        <tr v-for="el of data" :key="el.id" :class="{me: el.username === User.username}">
          <td>{{el.id}}</td>
          <td>{{el.username}}</td>
          <td>{{el.fullname}}</td>
          <td>{{el.email}}</td>
          <td>{{el.name_role}}</td>
          <td><img width="50" :src="'Server/src/imageUser/' + (el.image ?? 'default.png')"  alt=""></td>
          <td>{{el.reg_at}}</td>
          <td class="button"><Button @click="deleteUser(el.id)" class="red"><ReDeleteBinLine/></Button><Button @click="editUser(el)"><ClEditPencil01/></Button></td>
        </tr>
      </table>
    </div>

    <transition name="modal" duration="350">
      <ModalEditUser @close="modalEditUser = false" v-if="modalEditUser" :user="EditUser" :change-user="changeUser"/>
    </transition>

  </div>
</template>

<style scoped lang="scss">
@import "../../App";
  .Users {

    .table {
      @include table;
      .red {
        margin-right: 3px;
      }
    }
    .me {
      td {
        background-color: rgba(124, 29, 168, 0.28);
      }
    }
  }
</style>