<script setup>
import basket from "../assets/js/Basket.js";
import Counter from "../components/Counter.vue";
import {ref, watchEffect} from "vue";
import Button from "../components/Button.vue";
import Confirm from "../components/Confirm.vue";
import Check from "../components/Check.vue";

const confirm = ref(false)
const check = ref(false)
// const router = useRouter()

const checkConfirm = () => {
  confirm.value = false
  check.value = true
  // Сделать подтверждение и чек после покупки
}
const date = ref(new Date().toLocaleString())
const products = ref(basket.filterObject())
watchEffect(() => {
  products.value = basket.filterObject()
}, [basket.basket])
</script>

<template>
<div class="Basket">
  <h1 v-if="products.length !== 0">Корзина</h1>
  <h1 v-else>Корзина пуста</h1>
  <div class="products">
    <p class="product-none" v-if="products.length === 0">Перейдите в <router-link class="redirect" to="/Catalog">католог</router-link> и выберите товар</p>
    <div class="product" v-for="(product, index) in products">
     <div class="bl2 bl">
       <p>#{{index+1}}</p>

       <img :src="'Server/src/product/'+product.image" alt="">
       <div class="description">
         <h4>{{product.nameProduct}}</h4>
         <p>Модель: {{product.model}}</p>
       </div>
     </div>
      <div class="bl">
        <Counter :id="product.id"/>
        <h4>{{product.price * basket.getCountProduct(product.id)}} ₽</h4>
      </div>
      <p @click="basket.deleteProduct(product.id)" class="delete del">✖</p>
    </div>
    <div v-if="products.length !== 0" class="result">
      <h2>Итог: {{basket.getAllSumProducts()}} руб.</h2>
    </div>

    <Button v-if="products.length !== 0" @click="confirm = true">Оформить заказ</Button>
    <Transition name="confirm" :duration="{enter: 500, leave: 500}">
      <Confirm :check-confirm="checkConfirm" v-if="confirm"/>
    </Transition>
    <Check :date="date" @close="check = false" v-if="check" :products="products"/>

<!--    <h2 v-else>Корзина пуста</h2>-->

  </div>
</div>
</template>

<style scoped lang="scss">
@import "../App";
.confirm-enter-active .modalWindow {
  animation: openConfirm 0.8s;
}
.confirm-leave-active .modalWindow  {
  animation: openConfirm 0.8s reverse;
}
@keyframes openConfirm {
  from {
    transform:  translateY(-999px);
  }
  to {
    transform: translateY(0);
  }
}
.Basket {
  .product-none {
    text-align: center;
    font-size: 20px;
  }
  .result {
    text-align: end;
  }
  .bl {
    display: flex;
    align-items: center;
    gap: 30px;
    white-space: nowrap;
  }

  .redirect {
    color: $bgColor;
    font-weight: bold;
    &:hover {
      text-decoration: underline;
    }
  }
  margin-top: 25px;
  display: flex;
  flex-direction: column;
  gap: 30px;
  width: 80%;
  h1 {
    text-align: center;
  }
  .products {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;

  }
  .description {
    white-space: normal;
  }
  .product {
    position: relative;
    flex-wrap: wrap;
    align-items: end;
    justify-content: space-between;
    display: flex;
    box-shadow: 0 0 5px #646464;
    border-radius: 5px;
    padding: 15px;
    gap: 15px;
    > .description {
      text-align: start;
      max-width: 300px;
      min-width: 150px;
    }
    img {
      width: 150px;
    }
  }
}
.del {
  position: absolute;
  top: 10px;
  right: 10px;
}
.delete {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0.4;
  cursor: pointer;
  transition: opacity ease 0.5s;
  border-radius: 50%;
  border: 1px solid black;
  &:hover {
    opacity: 1;
  }

}
@media (width < 1050px) {
  .Basket {
    .product {
      justify-content: end;
    }
    .bl2 {
      width: 100%;
    }
  }
}
@media (width < 580px) {
  .Basket {
    width: 95%;
  }
}
@media (width < 480px) {
  .Basket {
    width: 95%;
    .bl2 {
      flex-wrap: wrap;
    }
  }
}
</style>