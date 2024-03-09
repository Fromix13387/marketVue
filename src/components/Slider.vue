
<script setup>

import emblaCarouselVue from 'embla-carousel-vue'
import {ref, watchEffect} from "vue";
import Autoplay from 'embla-carousel-autoplay'
const [emblaRef, emblaApi] = emblaCarouselVue({ loop: true },  [Autoplay()])
const tweenValues = ref([])
const numberWithinRange = (number, min, max) =>
    Math.min(Math.max(number, min), max)
const onScroll = () => {
    if (!emblaApi.value) return
    const engine = emblaApi.value.internalEngine()
    const scrollProgress = emblaApi.value.scrollProgress()

    tweenValues.value = emblaApi.value.scrollSnapList().map((scrollSnap, index) => {
        let diffToTarget = scrollSnap - scrollProgress

        if (engine.options.loop) {
            engine.slideLooper.loopPoints.forEach((loopItem) => {
                const target = loopItem.target()
                if (index === loopItem.index && target !== 0) {
                    const sign = Math.sign(target)
                    if (sign === -1) diffToTarget = scrollSnap - (1 + scrollProgress)
                    if (sign === 1) diffToTarget = scrollSnap + (1 - scrollProgress)
                }
            })
        }
        const tweenValue = 1 - Math.abs(diffToTarget * 4.2)
        return numberWithinRange(tweenValue, 0, 1)
    })
    console.log(tweenValues.value)
}

watchEffect(() => {
    if (!emblaApi.value) return
    onScroll()
    emblaApi.value.on('scroll', () => onScroll())
    emblaApi.value.on('reInit', onScroll)
}, [emblaApi, onScroll])
</script>
<template>
    <div class="embla"  >
        <div class="embla__viewport" ref="emblaRef">
            <div class="embla__container">
                <div :style="{...(tweenValues.length && { opacity: tweenValues[0]+ 0.5 })}" class="embla__slide"><img src="/src/assets/product/1.png" alt=""/></div>
                <div :style="{...(tweenValues.length && { opacity: tweenValues[1] + 0.5 })}" class="embla__slide"><img src="/src/assets/product/2.png" alt=""/></div>
                <div :style="{...(tweenValues.length && { opacity: tweenValues[2] + 0.5 })}" class="embla__slide"><img src="/src/assets/product/3.png" alt=""/></div>
                <div :style="{...(tweenValues.length && { opacity: tweenValues[3] + 0.5 })}" class="embla__slide"><img src="/src/assets/product/4.png" alt=""/></div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.embla {
    padding: 10px 40px;
    background-color: rgba(211, 211, 211, 0.53);
    width: 500px;
    user-select: none;
    img {
        width: 100%;
        height: 300px;
        object-fit: contain;
    }
}
.embla__viewport {
    overflow: hidden;
}
.embla__container {
    display: flex;

}
.embla__slide {
    flex: 70 0 65%;
    min-width: 0;
}
</style>