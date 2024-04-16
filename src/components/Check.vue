<script setup>

import basket from "../assets/js/Basket.js";
import Button from "./Button.vue";
import Modal from "./modal/Modal.vue";

const props = defineProps({
  products: Object,
  date: Date
})
</script>

<template>
  <Modal>
    <div class="Check">
      <h3 class="red">Заказ сформирован</h3>
      <div class="products">
        <div class="info">
          <p>Статус: <span class="new">Новый</span></p>
          <p>Дата: {{props.date ?? '00.00.00, 00.00.00'}}</p>
        </div>
        <div class="product" v-for="product of props.products">

          <hr>
          <br>
          <p class="code">№{{product.id}}</p>
          <p>{{product.nameProduct}}</p>
          <p>Модель: {{product.model}}</p>
          <p>Цена: {{product.price}}  ₽</p>
          <p>Количество: {{basket.getCountProduct(product.id)}} шт.</p>
          <p>Стоимость: {{product.price * basket.getCountProduct(product.id)}} ₽</p> <br>
          <hr>

        </div>
        <h4><span>Итог:</span> {{basket.getAllSumProducts()}} руб.</h4>
      </div>
      <Button @click="$emit('close')">Закрыть</Button>
    </div>
  </Modal>
</template>

<style scoped lang="scss">
@import "../App";
.red {
  color: #ff5b5b;

}
.code {
  color:#bebebe;
  font-size: 15px;
  text-align: center;
  width: 100%;
  margin-bottom: 5px
}
.Check {
  color: #eeeeee;
  padding: 15px;
  h3 {

    padding: 5px  0;
    letter-spacing: 1.2px;
    text-align: center;
  }
  .new {
    color: greenyellow;
  }
}
  .products {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 15px 10px;
    max-height: 300px;
    overflow-y: scroll;
    .product {
      background-color: rgba(255, 255, 255, 0.08);
      padding: 15px;
      border-radius: 5px;
    }
    h4 {
      text-align: end;
      span {
        letter-spacing: 1.3px;
      }
    }
  }
  .info {
    display: flex;
    justify-content: space-between;
  }
</style>