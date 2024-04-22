<script setup>


import {onMounted, ref} from "vue";
import {Fetch} from "../api/Fetch.js";
const data = ref([])
onMounted(async() => {
  data.value = await Fetch({method: 'getOrderHistory'})
})
</script>

<template>
  <div class="HistoryBuy">
    <h2>История покупок</h2>

    <div class="products">
      <div v-for="el of data">
        <img :src="'src/assets/product/' + el.image" alt="">
        <div>
          <div class="top">
            <h2>{{el.product}}</h2>
            <p class="date">{{el.created_at}}</p>
          </div>
          <p >{{el.description}}</p>
          <div class="top">
            <p class="status">Статус: {{el.status}}</p>
           <div class="info">
             <p class="price">{{el.count}} шт</p> |
             <p class="price">{{+el.price * +el.count}} ₽</p>
           </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "../App";
  .HistoryBuy {
    width: 80%;
    margin-top: 35px;
    display: flex;
    flex-direction: column;
    gap: 25px;
    .products {
      display: flex;
      flex-direction: column;
      gap: 20px;
      > div {
        box-shadow: 0 0 5px #646464;
        border-radius: 5px;
        padding: 15px;
        display: flex;
        gap: 15px;
        .top {
          display: flex;
          width: 100%;
          justify-content: space-between;
          gap: 5px;
          flex-wrap: wrap;
        }
        .status, .price {
          font-weight: bold;
        }
        .info {
          display: flex;
          gap: 10px;
        }
        .price {
          font-size: 20px ;
        }
        > div  {
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          gap: 15px;
        > p {
          font-size: 12px;
          color: grey;
        }

        }
        img {
          max-width: 200px;
          border-radius: 25px;
          object-fit: contain;
        }
      }
    }
  }
  @media (width < 1300px) {
    .HistoryBuy {
      width: 95%;
    }
  }
  @media (width < 690px) {
    .HistoryBuy {
      .top {
        h2 {
          font-size: 18px;
        }
        .date {
          font-size: 12px !important;
        }
      }
      .products {
        > div {
          > div {
            p {
              font-size: 10px;
            }
            .top {
              p {
                font-size: 15px;
              }
            }
          }
        }
      }
    }
  }
</style>