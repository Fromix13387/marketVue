
<script setup>

</script>
<template>
    <img width="100%" src="../../Server/src/product/Backdesktop.avif" alt="">
    <div class="home">
        <h1>Добро пожаловать</h1>

        <p>Покупать у нас это значит всегда оригинальные предложения в сфере традиционной печати. Основным направлением являются  цветные струйные решения. Ассортимент компании  представлен бизнес-принтерами (принтеры, МФУ, сканеры), а также устройствами для широкоформатной и профессиональной печати . Отличительной особенностью печатающей техники является ее экологичность и энергосбережение.
        </p>

        <div class="blockImg">
           <router-link to="catalog"> <img src="/Server/src/product/1.png" alt=""/></router-link>
           <router-link to="catalog"> <img src="/Server/src/product/2.png" alt=""/></router-link>
           <router-link to="catalog"> <img src="/Server/src/product/3.png" alt=""/></router-link>
           <router-link to="catalog"> <img src="/Server/src/product/4.png" alt=""/></router-link>
        </div>
    </div>
  <!--  <Slider/>-->
</template>

<style scoped lang="scss">
.home {
  width: 80%;
  padding: 10px;
  h1 {
    font-size: 55px;
  }
  p {
    margin-top:30px;
    font-size: 25px;
  }
    .blockImg {
        padding: 60px 0;
        justify-content: center;
        display: flex;
        gap: 100px;
        flex-wrap: wrap;
        img {
            cursor: pointer;
            max-width: 300px;
            max-height: 300px;
            width: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
            &:hover {
                transform: scale(1.1);
            }
        }
    }
}

@media (width < 800px) {
  .home {
    h1 {
      font-size: 35px;
    }
    p {
      font-size: 15px;
    }

    width: 95%;
  }
}

</style>