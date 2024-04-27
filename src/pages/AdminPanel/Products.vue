<script setup>
import { ReDeleteBinLine, ClEditPencil01  } from "@kalimahapps/vue-icons";
import Button from "../../components/Button.vue";
import {computed, onMounted, reactive, ref} from "vue";
import {Fetch} from "../../api/Fetch.js";
import ModalAddProduct from "../../components/modal/ModalAddProduct.vue";
import ModalEditProduct from "../../components/modal/ModalEditProduct.vue";

const data = ref([])
const visibleModal = ref('')
const deleteQuest = async (id) => {
  const res = await Fetch({method: 'deletePrinter',  id})
  if (res) data.value = data.value.filter(el => el.id !== id)
}
const changeProduct = (changeData) => {
  console.log(changeData)
  data.value = data.value.map(el => {
    console.log(el.id === changeData.id)
    return el.id === changeData.id ? changeData : el
  })
  console.log(data.value)
}
const addProduct = (product) => {
  data.value.push({...product, id: data.value.length - 1})
}
const editProductId = ref('')
const editProductFunc = computed(() => data.value.filter(el => el.id === editProductId.value)[0])
onMounted( async() => {
  data.value = await Fetch({method: 'getPrinters'}).then(res => res.sort((a,b) => a.id - b.id))
})
</script>

<template>
  <div class="Products">
    <Button @click="visibleModal='addProduct'">Добавить новый товар</Button>
    <div class="table">
      <table>
        <tr>
          <th>Номер</th>
          <th>Название</th>
          <th>Цена</th>
          <th>Описание</th>
          <th>Страна</th>
          <th>Год выпуска</th>
          <th>модель</th>
          <th>категория</th>
          <th>Фото</th>
          <th>количество</th>
          <th>Действия</th>
        </tr>
        <tr v-for="el of data" :key="el.id" >
          <td>{{el.id}}</td>
          <td>{{el.nameProduct}}</td>
          <td>{{el.price}}</td>
          <td class="desc">{{el.description}}</td>
          <td>{{el.nameCategory}}</td>
          <td>{{el.releaseYear}} </td>
          <td>{{el.model}}</td>
          <td>{{el.nameCountry}}</td>
          <td><img :src="'Server/src/product/'+ el.image" alt=""></td>
          <td>{{el.count}} шт</td>
          <td class="button"><Button @click="deleteQuest(el.id)" class="red"><ReDeleteBinLine/></Button><Button @click="() => {editProductId = el.id; visibleModal='editProduct'}"><ClEditPencil01/></Button></td>
        </tr>
      </table>
    </div>
    <transition name="modal" duration="350">
      <ModalAddProduct @add-product="addProduct"  @close="visibleModal = ''" v-if="visibleModal === 'addProduct'"/>
      <ModalEditProduct @edit-product="changeProduct"  @close="visibleModal = ''" v-else-if="visibleModal === 'editProduct'" :product="editProductFunc"/>
    </transition>
  </div>
</template>

<style scoped lang="scss">
@import "../../App";
.Products {
  display: flex;
  flex-direction: column;
  gap: 15px;
  .table {
    .desc {
      min-width: 300px;
      font-size: 12px;
    }
    @include table;
    .red {
      margin-right: 3px;
    }
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