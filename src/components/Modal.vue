<script setup>
</script>
<template>
  <Transition name="modal" :duration="500">
      <div @click="$emit('close')" class="modal">
          <div @click.stop.prevent class="modalWindow">
              <slot/>
          </div>
      </div>
  </Transition>
</template>


<style scoped lang="scss">
@import "../App";
  .modal {
      position: fixed;
      bottom: 0;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.51);
      align-items: center;
      justify-content: center;
      .modalWindow {
        position: relative;
          min-width: 350px;
          min-height: 200px;
          background-color: $bgColor;
          padding: 35px;
          border-radius: 15px;
      }
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