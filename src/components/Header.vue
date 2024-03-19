<script setup>
import Registration from "./Registration.vue";
import {ref} from "vue";
import Authorization from "./Authorization.vue";
import {RouterLink, useRoute, useRouter} from "vue-router";
import {defaultUrl, User, visibleModal} from "../main.js";
import ModalProfile from "./ModalProfile.vue";

// const visibleRegistration = ref(false)
// const visibleAuthorization = ref(false)



const props = defineProps({
  ...RouterLink.props,
  inactiveClass: String
})
const user = ref({})
const value = ref('')
const route = useRoute()
const router = useRouter()

const visibleProfile = ref(false)

function change() {
  router.replace(`${route.path}?search=${value.value}`)
}
</script>
<template>
    <div class='Header'>
        <div :style="{width: route.path.includes('/Catalog') ?  'clamp(340px, 50%, 500px)' : 'fit_content'}" class="search">
            <router-link to="/"><img src="/src/assets/icons/printer.png" alt=""/></router-link>
            <input v-model="value" @input="change()" placeholder="Название товара" v-show="route.path.includes('/Catalog')" type="text">
        </div>

        <div class="nav">
            <div>
                <router-link to="/">Главная</router-link>
                <router-link to="/About">О нас</router-link>
                <router-link to='/Catalog'>Каталог</router-link>
                <router-link to='/Contact'>Контакты</router-link>
            </div>
            <div :class="[{active: visibleProfile},'user-menu']" v-if="User.auth" @click="visibleProfile = !visibleProfile">
              <img v-if="User.image" :src="defaultUrl+'src/imageUser/' + User.image" alt="">
              <img v-else :src="defaultUrl+'src/imageUser/default.png'" alt="">

              <Transition name="profile">
                <ModalProfile v-show="visibleProfile"/>
              </Transition>
            </div>
            <div v-else>
                <p @click="visibleModal = 'registration'">Регистрация</p>
                <p @click="visibleModal = 'authorization'">Вход</p>
            </div>
        </div>
        <Transition name="modal" :duration="{enter: 500, leave: 500}"
          >
          <Registration v-if="visibleModal === 'registration'" @close="visibleModal = ''"/>
          <Authorization v-else-if="visibleModal === 'authorization'" @close="visibleModal = ''"/>
        </Transition>

    </div>

</template>



<style scoped lang="scss">
@import "https://fonts.fontstorage.com/import/abeezee.css";
@import "../App";
//  Profile animation styles

.profile-enter-active {
  animation: modalProfile 1s;
}
.profile-leave-active {
  animation: modalProfile .6s reverse;
}

@keyframes modalProfile {
  from {
    max-height: 0;
  }
  to {
    max-height: 300px;
  }
}

// Style component
.Header {
    * {
        letter-spacing: 1.2px;
        color: white;
    }

    padding: 5px;
    position: sticky;
    top: 0;
    gap: 1vmax;
    background-color: $bgColor;
    z-index: 3;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;

    > .nav {
      align-items: center;
        justify-content: center;
        display: flex;
        gap: 50px;
        flex-wrap: wrap;
        > div {
            flex-wrap: wrap;
            display: flex;
            gap: 15px;
            > * {
                transition: all 0.3s ease;
            }
            p:hover, a:hover {
                cursor: pointer;
                color: #696767;
            }
        }
    }
    .search {
        display: flex;
        gap: 15px;
        align-items:  center;
                > input {
            min-width: 250px;
            padding: 5px 10px;
            font-size: 15px;
            outline: none;
            color: black;
            border-radius: 2px;
            border: 0;
            width: 100%;
            height: fit-content;
            &:focus {
                box-shadow: 0 0 2px 2px $dopColor;
            }
        }
    }
  .user-menu {
    display: flex;
    border-radius: 15px;
    cursor: pointer;

    align-items: center;
    position: relative;
    img {
      width: 40px;
    }
    gap: 5px !important;

    &::after {
      transition: background-color 0.5s ease;
      content: "";
      border: 5px solid transparent;
      border-bottom: 6px solid black;
      margin-bottom: 7px;
    }
    &:hover::after {
      border-bottom-color: #1c8be0;
    }
    &.active::after {
      margin-top: 7px;
      border-top: 6px solid #46a8dc;
      border-bottom:0;
    }
  }
}
@media (width < 800px) {

}
@media (width < 600px) {
  .Header {
    .nav {
      gap: 20px;
    }
  }

}
</style>