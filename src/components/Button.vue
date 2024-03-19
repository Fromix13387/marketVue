<script setup>

</script>

<template>
  <button class="custom-button">
    <slot/>
  </button>
</template>

<style scoped lang="scss">
@import "../App";
  .custom-button {
    margin: auto;
    width: fit-content;
    padding: 8px 15px;
    background-color: $dopColor;
    border: none;
    color: white;
    font-size: 15px;
    border-radius: 10px;
    transition: background-color 0.3s ease, box-shadow 0.05s ease;
    cursor: pointer;
    &:hover {
      background-color: #f55050;
    }
    &:active {
      box-shadow: 0 0 5px white;
    }
  }
</style>