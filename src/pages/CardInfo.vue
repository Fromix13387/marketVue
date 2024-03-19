<script setup>
import {onMounted, ref} from "vue";
import {Fetch} from "../api/Fetch.js";
import {User, visibleModal} from "../main.js";
import Button from "../components/Button.vue";
import {addBasket, basket} from "../assets/js/Basket.js";

const data = ref({})
  const props = defineProps({
      id: Number
  })
  async function getPrinter() {
      data.value = await Fetch({method: 'getPrinter', id: props.id})
  }
  onMounted(() => {
      getPrinter()
  })
</script>

<template>
  <div v-if="data.id" class="CardInfo">
      <img :src="'src/assets/product/' + data.image" alt="">

      <div>
          <div>
              <h1>{{data.nameProduct}}</h1>
          </div>

          <div class="config">
              <table>
                  <tr class="gray">
                      <td><h5>Цена:</h5></td>
                      <td>{{data.price}} ₽</td>
                  </tr>
                  <tr>
                      <td><h5>Страна производитель:</h5></td>
                      <td>{{data.nameCountry}}</td>
                  </tr>
                  <tr class="gray">
                      <td><h5>Тип:</h5></td>
                      <td>{{data.nameCategory}}</td>
                  </tr>
                  <tr>
                      <td><h5>Год выпуска:</h5></td>
                      <td>{{data.releaseYear}}</td>
                  </tr>
                  <tr class="gray">
                      <td><h5>Модель:</h5></td>
                      <td>{{data.model}}</td>
                  </tr>
                  <tr>
                      <td><h5>На складе:</h5></td>
                      <td>{{data.count}}</td>
                  </tr>
                  <tr class="gray">
                      <td><h5>Описание:</h5></td>
                      <td>{{data.description}}</td>
                  </tr>
              </table>
          </div>

          <Button v-if = "User.auth && data.length !== 0" @click="basket.push(data)">В корзину</Button>
          <Button v-else @click="visibleModal = 'authorization'">Купить</Button>
      </div>
  </div>
</template>

<style scoped>
  .CardInfo {
      padding: 10px;
      margin-top: 50px;
      width: 70%;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
      > div {
          display: flex;
          flex-direction: column;
          gap: 15px;
      }
      img {
          object-fit: contain;
          max-width: 400px;
          width: 100%;
      }
      .config {
          table {
              border-spacing: 0;
              td {
                  padding: 10px;
              }
          }

      }
      .gray {
          background-color: #efeded;
      }
    button {
         min-width: 200px;
         width: 30%;
    }
  }
  @media (width < 750px) {
      .CardInfo {
          width: 100%;
      }
  }
</style>