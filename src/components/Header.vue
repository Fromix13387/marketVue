<script setup>
import Registration from "./Registration.vue";
import {ref, watch, watchEffect} from "vue";
import Authorization from "./Authorization.vue";
import {RouterLink, useRoute, useRouter} from "vue-router";

const visibleRegistration = ref(false)
const visibleAuthorization = ref(false)

const props = defineProps({
  ...RouterLink.props,
  inactiveClass: String
})
const value = ref('')
const route = useRoute()
const router = useRouter()
function change() {
  console.log(router)
  router.replace(`${route.path}?search=${value.value}`)
}
</script>
<template>
    <div class='Header'>
        <div class="search">
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
            <div>
                <p @click="visibleRegistration = !visibleRegistration">Регистрация</p>
                <p @click="visibleAuthorization = !visibleAuthorization">Вход</p>
            </div>
        </div>

        <Registration v-show="visibleRegistration" @close="visibleRegistration = false"/>
        <Authorization v-show="visibleAuthorization" @close="visibleAuthorization = false"/>
    </div>

</template>



<style scoped lang="scss">
@import "https://fonts.fontstorage.com/import/abeezee.css";
@import "../App";

.Header {
    * {
        //font-family: ABeeZee, italic ;
        letter-spacing: 1.2px;
        color: white;
    }
    padding: 10px 40px;
    position: sticky;
    top: 0;
    gap: 25px;
    background-color: $bgColor;
    z-index: 3;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;

    > .nav {
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
        align-items: center;

        > input {
            min-width: 400px;
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
}
@media (width < 1150px) {
    .Header {
        justify-content: center;
    }

}
</style>