<script setup>
  const props = defineProps({
      data: Array
  })
</script>

<template>
  <div class="card">

      <img :src="'src/assets/product/' + props.data.image" alt="">
      <div>
          <div>
              <router-link :to="'/printer/'+ props.data.id"><h4>{{props.data.nameProduct}}</h4></router-link>
              <p>Модель: {{props.data.model}}</p>
          </div>
          <div class="price">
              <h3>{{props.data.price}} ₽</h3>
              <router-link :to="'/printer/'+ props.data.id">Купить</router-link>
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

          a {
              padding: 5px 25px;
              border: none;
              background-color: $dopColor;
              color: white;
              border-radius: 10px;
              font-size: 15px;
              cursor: pointer;
            transition: background-color 0.3s ease;
            &:hover {
              background-color: #d92d2d;
            }
          }
      }
  }
</style>