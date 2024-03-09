<script setup>
import {onMounted, ref} from "vue";
import {Fetch} from "../api/Fetch.js";
import Card from "../components/Card.vue";
import {onBeforeRouteUpdate} from "vue-router";

const data = ref([])

async function getData(search) {
    data.value = await Fetch({method: 'getPrinters', search})
}
onBeforeRouteUpdate( to => {
  getData(to.query.search)
})
onMounted(() => {
    getData()
})
</script>

<template>
  <div class="Catalog">
      <h1>Наши товары</h1>
      <div class="filters">

      </div>
      <div class="cards">
          <Card v-for="el of data" :data="el"/>
      </div>
  </div>
</template>

<style scoped>
  .Catalog {
      width: 100%;
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
      padding: 15px 40px;
      display: grid;
      grid-template-columns: repeat(3, 33%);
      grid-auto-rows: auto;
      gap: 15px;
      justify-content: center;
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