<script setup>
import vSelect from "vue-select";
import Modal from "./Modal.vue";
import {onMounted, ref, watch, watchEffect} from "vue";
import {Fetch} from "../../api/Fetch.js";
import Button from "../Button.vue";
const props = defineProps({
  user: Object,
  changeUser: Function
})
const fullname = ref(props.user.fullname)
const email = ref(props.user.email)
const img = ref(props.user.image)
const notice = ref('')

const role = ref([])
const selected = ref({id: '', name_role: ''})

const editUser = async () => {
  const res = await Fetch({
    method: 'editUser',
    role: selected.value.id,
    image: image.value,
    fullname: fullname.value,
    email: email.value,
    id: props.user.id
  })
  props.changeUser(fullname.value, email.value, img.value,selected.value)
}
onMounted( async() => {
  role.value = await Fetch({method: 'getRole'})
  selected.value = role.value.filter(el => el.id === props.user.role)[0]
})

</script>

<template>
  <Modal class="ModalUser">
    <div  class="ModalEditUser">
      <h1>Редактирование</h1>
      <input v-model="fullname" type="text" placeholder="ФИО"/>
      <input v-model="email" type="text" placeholder="Почта"/>
      <vSelect v-model="selected" placeholder="Ничего не выбрано"  :options="role" label="name" code="id">
        <template #no-options='option'>Значение не найдено</template>
        <template #selected-option="{ name_role, id }">{{name_role}}</template>
      </vSelect>
      <Button @click="editUser">Сохранить</Button>
    </div>

  </Modal>
</template>
<style>
.ModalUser .content-modal {
  max-width: 350px;
  min-height: 200px;
  padding: 25px 15px;
}
</style>
<style scoped lang="scss">
@import "../../App";
.ModalEditUser {
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 20px;
  > h1 {
    font-size: 20px;
    color: white;
    text-align: center;
  }
  input,div {
    min-width: 49%;
  }
  input {
    @include input;
  }
  button {
    width: 200px;
  }
}
</style>