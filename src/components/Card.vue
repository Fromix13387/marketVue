<script setup>
import {User, visibleModal} from "../main.js";
import Button from "./Button.vue";
import basket from "../assets/js/Basket.js";
import Counter from "./Counter.vue";


  const props = defineProps({
      data: Array
  })
</script>

<template>
  <div :class="[{active: User.auth && !!basket.getCountProduct(props.data.id)}, 'card']">

      <img :src="'Server/src/product/' + props.data.image" alt="">
      <div>
          <div>
              <router-link :to="'/printer/'+ props.data.id"><h4>{{props.data.nameProduct}}</h4></router-link>
              <p>Модель: {{props.data.model}}</p>
          </div>
          <div class="price">
              <h3>{{props.data.price}} ₽</h3>
              <Counter v-if="User.auth && basket.getCountProduct(props.data.id) !== 0" :id="props.data.id"/>
              <Button v-else-if="User.auth && data.length !== 0" @click="basket.addBasket(props.data)">В корзину</Button>
              <Button v-else @click="visibleModal = 'authorization'">Купить</Button>
          </div>
      </div>
  </div>
</template>

<style scoped lang="scss">
  @import "../App";
  .card {
      img {
          width: 150px;
          object-fit: contain;
      }
      p {
          font-size: 14px;
        color: gray;
      }
      h4 {
        color: $bgColor;
        transition: color 0.3s ease;
          margin-bottom: 5px;
        cursor: pointer;
          &:hover {
            color: $dopColor;
          }
      }

    display: flex;
      gap: 15px;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 0 100px #eae8e8, 0 0 5px #857f7f;
      > div {
          width: 100%;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          gap: 10px;
      }
      .price {
        flex-wrap: wrap;
        gap: 10px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          > button {
            margin: 0;
          }
      }

  }
  .active {
    background-color: rgba(203, 86, 86, 0.21);
  }
</style>