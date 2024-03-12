<script setup>
  const props = defineProps({
    text: String,
    type: String
  })
</script>

<template>
  <Transition>
    <div class="Message">
      <p :class="props.type">{{props.text}}</p>
    </div>
  </Transition>
</template>

<style scoped lang="scss">
@import "../App";
.Message {
  text-align: center;
  top:8px;
  left: 5px;
  border-radius: 20px;
  position: absolute;
  min-width: 100%;
  height: 50px;
  font-size: 15px;
}
  .success {
    color: greenyellow;
  }
  .error {
    color: #ff0202;
  }
  .modal-enter-active .modalWindow  {
    animation: modalOpen .6s;
  }
  .modal-leave-active .modalWindow {
    animation: modalOpen .6s reverse;
  }

  @keyframes modalOpen {
    from {
      transform: scale(0);
    }
    to {
      transform: scale(1);
    }
  }
</style>