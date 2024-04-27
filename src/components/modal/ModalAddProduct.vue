<script setup>

import Modal from "./Modal.vue";
import {onMounted, ref} from "vue";
import Button from "../Button.vue";
import {Fetch} from "../../api/Fetch.js";
import vSelect from "vue-select";
const nameProduct = ref('')
const price = ref('')
const description = ref('')
const releaseYear = ref('')
const model = ref('')
const count = ref('')
const image = ref('')
const img = ref('')

const emits = defineEmits(['addProduct'])

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
const categories = ref([])
const countries = ref([])
const selected_category = ref({id: '', nameCategory: ''})
const selected_country= ref({id: '', nameCountry: ''})

onMounted( async() => {
  categories.value = await Fetch({method: 'getCategories'})
  countries.value = await Fetch({method: 'getCountries'})

})

const notice = ref('')
const addProduct = async () => {
  const data = {
    method: 'addPrinter',
    nameProduct: nameProduct.value,
    price: price.value,
    description: description.value,
    category_id: selected_category.value?.id,
    country_id: selected_country.value?.id,
    releaseYear: releaseYear.value,
    model: model.value,
    count: count.value,
    image: image.value
  }
  const res = await Fetch(data)
  if (+res) {
    notice.value = {text: 'Принтер успешно добавлен', status: 'success'}
    emits('addProduct', {...data, image: image.value.name ?? '1.png'})
  } else {
    notice.value = {text: res.error_message, status: 'error'}

  }
}

</script>

<template>
  <Modal class="ModalProduct">
    <div  class="ModalAddProduct">
      <h3 align="center">Добавление товара</h3>
      <p align="center" :class="notice.status" v-if="notice.text !== ''" @click="notice.text = ''">{{notice.text}}</p>
      <img :src="img" alt="" v-if="img !== ''">
      <input v-model="nameProduct" type="text" placeholder="Название"/>
      <input v-model="price" type="number" placeholder="Цена"/>
      <input v-model="releaseYear" type="number" placeholder="Год выпуска"/>
      <input v-model="model" type="text" placeholder="Модель"/>
      <input v-model="count" type="number" placeholder="Количество"/>
      <vSelect v-model="selected_category" placeholder="Ничего не выбрано"  :options="categories" label="nameCategory" code="id">
        <template #no-options='option'>Значение не найдено</template>
        <template #selected-option="{ id, nameCategory}">{{nameCategory}}</template>
      </vSelect>
      <vSelect v-model="selected_country" placeholder="Ничего не выбрано"  :options="countries" label="nameCountry" code="id">
        <template #no-options='option'>Значение не найдено</template>
        <template #selected-option="{ id, nameCountry}">{{nameCountry}}</template>
      </vSelect>
      <textarea rows="10" v-model="description" type="text" placeholder="Описание"/>
      <input @change="uploadFile" type="file" placeholder="Описание"/>
      <Button @click="addProduct">Добавить</Button>
    </div>

  </Modal>
</template>
<style lang="scss">
@import "../../App";

</style>
<style scoped lang="scss">
@import "../../App";
.ModalAddProduct {
  padding: 20px ;
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 500px;
  img {
    margin: auto;
    width: 150px;
  }
  h2 {
    text-align: center;
  }
  input,div {
    min-width: 49%;
  }
  input, textarea {
    @include input;
  }
  button {
    width: 200px;
  }
}
@media (width < 500px) {
  .ModalAddProduct {
    width: 100%;
  }
}
.success {
  color: lawngreen;
}
.error {
  color: red;
}
</style>