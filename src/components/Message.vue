<script setup>
  const props = defineProps({
    text: String,
    type: String,
    visible: Boolean
  })
</script>

<template>
  <Transition name="message" >
    <div class="Message" v-show="props.visible">
      <p :class="props.type">{{props.text}}</p>
    </div>
  </Transition>
</template>

<style scoped lang="scss">
@import "../App";
.Message {
  box-shadow: inset 0 0 99px $bgColor;
  bottom:8px;
  z-index: -1;
  display: flex;
  align-items: center;
  justify-content: center;
  left: 0;
  right: 0;
  border-radius: 20px;
  position: absolute;
  padding: 5px 15px;
  height: 50px;
  font-size: 15px;
  transform: translate3d(0px, 60px, 0);
}
  .success {
    color: greenyellow;
  }
  .error {
    color: rgb(246, 0, 47);
    font-weight: bold;
    letter-spacing: 0.3px;
  }
  .message-enter-active  {
    animation: messageOpen .6s;
  }
  .message-leave-active{
    animation: messageOpen .6s reverse;
  }
  @keyframes messageOpen {
    from {
      transform: translate3d(0, 0, 0);
    }
    to {
      transform: translate3d(0px, 60px, 0);
    }
  }
</style>