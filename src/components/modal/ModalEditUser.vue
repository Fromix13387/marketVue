<script setup>
import vSelect from "vue-select";
import Modal from "./Modal.vue";
import {onMounted, ref} from "vue";
import {Fetch} from "../../api/Fetch.js";
import Button from "../Button.vue";
import { MdOutlinedPhotoCamera } from "@kalimahapps/vue-icons";
const props = defineProps({
  user: Object,
  changeUser: Function
})
const fullname = ref(props.user.fullname)
const email = ref(props.user.email)
const image = ref('')
const img = ref('Server/src/imageUser/'+props.user.image)
const notice = ref('')

const hoverPhoto = ref(false)
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
  props.changeUser(fullname.value, email.value, image.value.name,selected.value)
}
onMounted( async() => {
  role.value = await Fetch({method: 'getRoles'})
  selected.value = role.value.filter(el => el.id === props.user.role)[0]
  console.log(role.value)
})
const uploadFile = (event) => {
  image.value = event.target.files[0]
  if (!FileReader) {
    alert('FileReader не поддерживается — облом');
    return;
  }
  const fileReader = new FileReader();
  fileReader.onload = function() {
    img.value = fileReader.result;
    console.log(img.value)
  }
  fileReader.readAsDataURL(event.target.files[0]);
}
</script>

<template>
  <Modal class="ModalUser">
    <div  class="ModalEditUser">
      <h1>Редактирование</h1>
      <div @mouseenter="hoverPhoto = true" @mouseleave="hoverPhoto = false"  class="img">
        <img :src="img" alt="">
        <MdOutlinedPhotoCamera class="icon" v-show="hoverPhoto"/>
        <input class="file" @change="uploadFile" type="file"/>
      </div>
      <input v-model="fullname" type="text" placeholder="ФИО"/>
      <input v-model="email" type="text" placeholder="Почта"/>
      <vSelect v-model="selected" placeholder="Ничего не выбрано"  :options="role" label="name_role" code="id">
        <template #no-options='option'>Значение не найдено</template>
        <template #selected-option="{ id, name_role }">{{name_role}}</template>
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
  > .img {
    margin: auto;
    width: 150px;
    @include profileImg;
    position: relative;
    img {
      width: 100%;
    }
    svg {
      width: 90%;
    }
  }
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