<script setup>
import {onMounted, ref, watch, watchEffect} from "vue";
import {Fetch} from "../api/Fetch.js";
import Card from "../components/Card.vue";
import {onBeforeRouteUpdate} from "vue-router";
import Slider from '@vueform/slider'

const data = ref([])
const value = ref([0,70000])
async function getData([min,max], search) {
    data.value = await Fetch({method: 'getPrinters', search, min, max})
}
onBeforeRouteUpdate( to => {
  getData(value.value, to.query.search)
})
watchEffect(() => {
  getData(value.value)
}, [value])

</script>

<template>
  <div class="Catalog">
      <h1>Наши товары</h1>
      <div class="filterIcon">
          <img src="/src/assets/icons/filter.png" alt="">
          <h4>Фильтры</h4>
      </div>
      <div class="filter">
        <div class="price">
          <Slider class="slider" :tooltips="false" :max="70000" v-model="value" />
          <div class="price-input">
            <input v-model="value[0]" type="number" placeholder="min">
            <input v-model="value[1]" type="number" placeholder="max">
          </div>

        </div>
      </div>
      <div class="cards">
          <Card v-for="el of data" :data="el"/>
      </div>
  </div>
</template>
<style src="@vueform/slider/themes/default.css"></style>
<style scoped>
.slider {
  margin-left: 7px;
  max-width: 235px;
}
.price {
  display: flex;
  flex-direction: column;
  gap: 15px;
  .price-input {
    display: flex;
    gap: 10px;
    > input {
      padding: 2px 5px;
      width: 50%;
    }
  }
}
.filter {
  max-width: 250px;
}
.filterIcon {
  display: flex;
  align-content: end;
  cursor: pointer;

  &:hover {
    h4 {
      transition: all 0.5s ease;
      color: #333232;
    }
  }
  gap: 5px;
  img {
    width: 15px;
  }
}
  .Catalog {
      width: 95%;
      margin-top: 25px;
      display: flex;
      flex-direction: column;
      gap: 30px;
      align-content: center;
      > h1 {
          text-align: center;
      }
  }
  .cards {
      display: grid;
      grid-template-columns: repeat(3, 33%);
      grid-auto-rows: auto;
      gap: 15px;
      justify-content: center;
    margin-bottom: 50px;
  }
  @media (width < 1050px) {
      .cards {
          grid-template-columns: repeat(2, 50%);
      }
  }
  @media (width < 725px) {
      .cards {
          grid-template-columns: 100%;
      }
  }
</style>