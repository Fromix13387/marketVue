<script setup>
import basket from "../assets/js/Basket.js";
import {watch, watchEffect} from "vue";

const props = defineProps({
  id: Number
})

</script>

<template>
<div class="counter">
  <div @click="basket.removeProduct(props.id)" class="button">-</div>
  <h4>{{basket.getCountProduct(props.id)}}</h4>
  <div  @click="basket.addBasket(basket.getProduct(props.id)[0])" :class="[{disabled: basket.getCountProduct(props.id) >= basket.getProduct(props.id)[0].count}, 'button']">+</div>
</div>
</template>

<style scoped lang="scss">
@import "../App";
  .counter {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    .button {
      border-radius: 5px;
      color: black;
      cursor: pointer;
      font-size: 20px;
      background-color: rgba(38, 38, 38, 0.09);
      transition: background-color 0.3s ease;
      padding: 3px 12px;
      &:hover {
        background-color: rgba(185, 88, 88, 0.48);
      }
    }
    .disabled {
      pointer-events: none;
      background-color: rgba(128, 128, 128, 0.56);
    }
  }
</style>