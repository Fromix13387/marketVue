<script setup>

import Modal from "./Modal.vue";
import {onMounted, ref} from "vue";
import Button from "../Button.vue";
import {Fetch} from "../../api/Fetch.js";
import vSelect from "vue-select";
import { MdOutlinedPhotoCamera } from "@kalimahapps/vue-icons";
const props = defineProps({
  product: Object
})
const nameProduct = ref(props.product.nameProduct)
const price = ref(props.product.price)
const description = ref(props.product.description)
const releaseYear = ref(props.product.releaseYear)
const model = ref(props.product.model)
const count = ref(props.product.count)
const image = ref('')
const img = ref('Server/src/product/'+props.product.image)

const emits = defineEmits(['editProduct'])

const uploadFile = (event) => {
  image.value = event.target.files[0]
  if (!FileReader) {
    alert('FileReader не поддерживается — облом');
    return;
  }
  const fileReader = new FileReader();
  fileReader.onload = function() {
    img.value = fileReader.result;
  }
  fileReader.readAsDataURL(event.target.files[0]);
}
const categories = ref([])
const countries = ref([])
const selected_category = ref({category_id: '', nameCategory: ''})
const selected_country= ref({country_id: '', nameCountry: ''})

onMounted( async() => {
  categories.value = await Fetch({method: 'getCategories'}).then(res => res.map(el => {
    return {category_id: el.id, nameCategory: el.nameCategory}
  }))
  countries.value = await Fetch({method: 'getCountries'}).then(res => res.map(el => {
    return {country_id: el.id, nameCountry: el.nameCountry}
  }))
  selected_category.value = categories.value.filter(el => el.category_id === props.product.category_id
  )[0]
  selected_country.value = countries.value.filter(el => el.country_id === props.product.country_id)[0]
})
const hoverPhoto = ref(false)
const notice = ref('')
const EditProduct = async () => {
  const data = {
    method: 'editPrinter',
    nameProduct: nameProduct.value,
    price: price.value,
    description: description.value,
    category_id: selected_category.value?.category_id,
    country_id: selected_country.value?.country_id,
    releaseYear: releaseYear.value,
    model: model.value,
    count: count.value,
    image: image.value,
    id: props.product.id
  }
  const res = await Fetch(data)
  if (+res) {
    notice.value = {text: 'Принтер успешно изменён', status: 'success'}
    console.log(data, {...selected_category.value, ...selected_country.value})
    emits('editProduct', {...data, image: image.value.name ?? props.product.image, ...selected_category.value, ...selected_country.value})
  } else {
    notice.value = {text: res.error_message, status: 'error'}

  }

}

</script>

<template>
  <Modal class="ModalProduct">
    <div  class="ModalAddProduct">
      <h3 align="center">Редактирование</h3>
      <p align="center" :class="notice.status" v-if="notice.text !== ''" @click="notice.text = ''">{{notice.text}}</p>
      <div @mouseenter="hoverPhoto = true" @mouseleave="hoverPhoto = false"  class="img">
        <img :src="img" alt="">
        <MdOutlinedPhotoCamera class="icon" v-show="hoverPhoto"/>
        <input class="file" @change="uploadFile" type="file"/>
      </div>
      <input v-model="nameProduct" type="text" placeholder="Название"/>
      <input v-model="price" type="number" placeholder="Цена"/>
      <input v-model="releaseYear" type="number" placeholder="Год выпуска"/>
      <input v-model="model" type="text" placeholder="Модель"/>
      <input v-model="count" type="number" placeholder="Количество"/>
      <vSelect v-model="selected_category" placeholder="Ничего не выбрано"  :options="categories" label="nameCategory" code="category_id">
        <template #no-options='option'>Значение не найдено</template>
        <template #selected-option="{ category_id, nameCategory}">{{nameCategory}}</template>
      </vSelect>
      <vSelect v-model="selected_country" placeholder="Ничего не выбрано"  :options="countries" label="nameCountry" code="country_id">
        <template #no-options='option'>Значение не найдено</template>
        <template #selected-option="{ country_id, nameCountry}">{{nameCountry}}</template>
      </vSelect>
      <textarea rows="10" v-model="description" type="text" placeholder="Описание"/>
      <Button @click="EditProduct">Именить</Button>
    </div>

  </Modal>
</template>
<style lang="scss">
@import "../../App";

</style>
<style scoped lang="scss">
@import "../../App";
.ModalProduct {
  :deep(.modalWindow) {
    overflow-y: scroll;
    max-height: 80vh;
    @include scrollModal;
  }
}
.ModalAddProduct {
  padding: 20px ;
  display: flex;
  flex-direction: column;

  gap: 15px;
  width: 500px;
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