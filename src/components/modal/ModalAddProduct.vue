<script setup>

import Modal from "./Modal.vue";
import {ref} from "vue";
import Button from "../Button.vue";
import {Fetch} from "../../api/Fetch.js";

const name = ref('')
const short_intro = ref('')
const age_limit = ref('')
const human_count = ref('')
const time = ref('')
const level_difficulty = ref('')
const price = ref('')
const descriptions = ref('')
const image = ref('')

const emits = defineEmits(['addQuest'])
const uploadFile = (event) => {
  image.value = event.target.files[0]
}
const notice = ref('')
const addQuest = async () => {
  const data = {
    method: 'addQuest',
    name: name.value,
    short_intro: short_intro.value,
    age_limit: age_limit.value,
    human_count: human_count.value,
    time: time.value,
    level_difficulty: level_difficulty.value,
    price: price.value,
    descriptions: descriptions.value,
    image: image.value
  }
  const res = await Fetch(data)
  if (+res) {
    notice.value = {text: 'Квест успешно добавлен', status: 'success'}
    emits('addQuest', {...data, image: image.value.name ?? '28.jpg'})
  }
}

</script>

<template>
  <Modal class="ModalQuest" :notice="notice" @closeNotice="notice=''">
    <div  class="ModalAddQuest">
      <h2>Добавление квеста</h2>
      <input v-model="name" type="text" placeholder="Название"/>
      <input v-model="short_intro" type="text" placeholder="Краткое описание"/>
      <input v-model="age_limit" type="number" placeholder="Возрастное ограничение"/>
      <input v-model="human_count" type="text" placeholder="Количество возможных игроков"/>
      <input v-model="time" type="text" placeholder="Время нужное для прохождения"/>
      <input v-model="level_difficulty" type="number" placeholder="Уровень сложности"/>
      <input v-model="price" type="number" placeholder="Строимость квеста"/>
      <textarea rows="5" v-model="descriptions" type="text" placeholder="Описание"/>
      <input @change="uploadFile" type="file" placeholder="Описание"/>
      <Button @click="addQuest">Добавить</Button>
    </div>

  </Modal>
</template>
<style lang="scss">
@import "../../App";
.ModalQuest .content-modal {
  @include scrollModal;
  max-width: 500px;
  min-height: 200px;
  max-height: 800px;
  padding: 25px 15px;
  overflow-y: scroll;

}
</style>
<style scoped lang="scss">
@import "../../App";
.ModalAddQuest {
  padding: 20px 10px 0 10px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  h2 {
    text-align: center;
  }
  input,div {
    min-width: 49%;
  }
  input, textarea {
    @include input;
  }
  button {
    width: 200px;
  }
}
</style>