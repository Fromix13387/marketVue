

<script setup>

    import {ref} from "vue";
    const visible = ref(true)

</script>

<template>
  <div class="contact">
      <h1>Контакты Челябинск</h1>

      <div @click="visible = !visible" :class="[{contact_active: visible}, 'contact_title']">
          <div>
              <img class="imgMark" src="../assets/icons/1.png" alt="">
              <p>ул. Гагарина 7</p>
          </div>
          <div>
              <p>Официальный магазин в Челябинске - расходные материалы и печатающие устройства</p>
              <div class="imgArrow"></div>
          </div>

      </div>
      <transition name="contact">
          <div v-if="visible" class="contact-main">
              <div>
                  <div>
                      <h3>Контакты</h3>
                      <p>+7 (495) 123-45-67</p>
                      <p>Email: info@mail.ru</p>
                  </div>

                  <div>
                      <h3>Юридический адрес</h3>
                      <p>Юридический адрес: г. Челябинск, ул. Гагарина, д. 7
                      </p>
                  </div>
                  <div>
                      <h3>Часы работы</h3>
                      <p>пн-пт 10:00-19:00</p>
                  </div>
              </div>

              <div class="card" style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/56/chelyabinsk/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Челябинск</a><a href="https://yandex.ru/maps/56/chelyabinsk/house/ulitsa_gagarina_7/YkgYcgNkTEAOQFtvfX11c3VgYg==/?indoorLevel=1&ll=61.444559%2C55.142937&utm_medium=mapframe&utm_source=maps&z=17.06" style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Гагарина, 7 — Яндекс Карты</a><iframe src="https://yandex.ru/map-widget/v1/?indoorLevel=1&ll=61.444559%2C55.142937&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1NjAyNDI0ORJA0KDQvtGB0YHQuNGPLCDQp9C10LvRj9Cx0LjQvdGB0LosINGD0LvQuNGG0LAg0JPQsNCz0LDRgNC40L3QsCwgNyIKDTnHdUIVXpJcQg%2C%2C&z=17.06" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
          </div>
      </transition>

  </div>
</template>

<style scoped lang="scss">

@import "../App";

.contact-enter-active, {
    animation: context 1.5s;
}
.contact-leave-active {
    animation: context 0.5s reverse;
}

@keyframes context {
    from {
        max-height: 0;
    }
    to {
        max-height: 700px;
    }
}
.imgMark, .imgArrow {
    width: 20px;
}

.contact-main {
    display: flex;
    gap: 40px;
    overflow: hidden;
    justify-content: space-between;
    > div {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 40px;
        width: 30%;
        > div {
            height: fit-content;
            display: flex;
            gap: 10px;
            flex-direction: column;
            max-width: 250px;
        }

    }
    .card {
        width: 70%;
    }
}
.contact_active {
    background-color: $dopColor !important;

    &:before {
        margin-top: 3px;
        background: url("../assets/icons/sprite-arrow.png") 0 -288px no-repeat !important;
    }
}
.contact {
  display: flex;
  flex-direction: column;
  gap: 40px;
  width: 80%;
  margin-top: 70px;
  h1 {
    font-size: 40px;
  }

  .contact_title {
      gap: 15px;
    flex-wrap: wrap;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
      position: relative;
    background-color: $bgColor;
      transition: all 0.6s ease;
      cursor: pointer;
      &:hover  {
          background-color: $dopColor;
      }
      &:before {
          width: 20px;
          right: 20px;
          top: 0;
          bottom: 0;
          margin:auto;
          height: 15px;
          position: absolute;
          content: "";
          background: url("../assets/icons/ar-bottom.png") no-repeat;
      }
    > div {
        display: flex;
        gap: 15px;
    }
    p {
      text-align: center;
      color: white;
    }
    > * {
      font-weight: bold;
    }
  }
}

@media (width < 850px) {
    .contact-main {
        flex-wrap: wrap;

        > div {
            display: flex;
            width: 100% !important;
        }
    }
}
</style>