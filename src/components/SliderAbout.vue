
<script setup>

import emblaCarouselVue from 'embla-carousel-vue'
import {watchEffect} from "vue";
import Autoplay from 'embla-carousel-autoplay'
const [emblaRef, emblaApi] = emblaCarouselVue({ loop: true },  [Autoplay()])

const scrollPrev = () => emblaApi.value && emblaApi.value.scrollPrev()
const scrollNext = () => emblaApi.value && emblaApi.value.scrollNext()

</script>
<template>
    <div class="embla"  >
        <div class="embla__viewport" ref="emblaRef">
            <div class="embla__container">
                <div class="embla__slide"><p>Мы являемся технологической компанией, в которой считают, что получение прибыли — это не самое главное. Каждая компания должна стремиться сделать мир лучше.</p></div>
                <div class="embla__slide"><p>Наши усилия по улучшению климата, защите прав человека и достижению цифрового равенства говорят о том, что мы делаем для этого все возможное.</p></div>
                <div class="embla__slide"><p>Более 80 лет работы подтверждают наши намерения, у нас сформировалось представление о мире будущего, в котором инновации создают основу для значительного улучшения жизни людей.</p></div>
                <div class="embla__slide"><p>Наши технологии, а также портфель продуктов и услуг, включающий персональные системы, принтеры и решения для 3D-печати, созданы для реализации этих значимых процессов.</p></div>
                <div class="embla__slide"><p>Мы знаем, что великие идеи могут рождаться в любое время, в любом месте и у любого человека.</p></div>
            </div>
        </div>
        <button @click="scrollPrev" class="embla__button embla__button--prev">
            <svg  viewBox="0 0 532 532">
                <path
                    fill="currentColor"
                    d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z"
                />
            </svg>
        </button>
        <button @click="scrollNext" class="embla__button embla__button--next">
            <svg viewBox="0 0 532 532">
                <path
                    fill="currentColor"
                    d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z"
                />
            </svg>
        </button>
    </div>
</template>
<style scoped lang="scss">
@import "../_App";
.embla__button {
    cursor: pointer;
    transition: all 0.3s ease;
    &:hover {
        background-color: #a4a4a4;
    }
    &.embla__button--next {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
    }
    &.embla__button--prev {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
    }
    border: none;
    svg {
        color: $bgColor;
        width: 50px;

    }

}
.embla {
    position: relative;
    background-color: rgba(211, 211, 211, 0.19);
    width: 100%;
    padding: 0 50px;
    min-height: 130px;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;

}
.embla__viewport {
    width: 80%;
    overflow: hidden;
}
.embla__container {
    display: flex;

}
.embla__slide {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
    text-align: center;
    height: 100px;
    > p {
        width: 100%;

    }
}
@media (width < 1220px) {
    .embla__slide {
        font-size: 20px;
    }
}
@media (width < 800px) {
    .embla {
        padding: 0 25px;
    }
    .embla__slide {
        height: 200px;
    }
}
@media (width < 500px) {
    .embla__slide {
        font-size: 15px;
    }
    .embla__button {
        svg {
            width: 30px;

        }
    }

}

</style>