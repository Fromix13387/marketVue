<script setup>
</script>
<template>
    <div @click.self="$emit('close')" class="modal">
        <div  class="modalWindow">
            <slot/>
        </div>
    </div>
</template>


<style scoped lang="scss">
@import "../../App";
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
          border-radius: 15px;
      }
  }

  .modal-enter-active .modalWindow  {
      animation: modalOpen .6s;
  }
  .modal-leave-active .modalWindow {
      animation: modalClose 0.8s;
  }

  @keyframes modalOpen {
    from {
      transform: scale(0);
    }
     to {
       transform: scale(1);
     }
  }
@keyframes modalClose {
  from {
    transform: translateY(0);
  }
  to {
    transform: translateY(-999px);
  }
}

.confirm-enter-active .modalWindow {
  animation: openConfirm 0.8s;
}
.confirm-leave-active .modalWindow {
  animation: openConfirm 0.5s reverse;
}
@keyframes openConfirm {
  from {
    transform:  translateY(-999px);
  }
  to {
    transform: translateY(0);
  }
}
</style>