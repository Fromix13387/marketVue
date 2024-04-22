<script setup>

import Modal from "./Modal.vue";
import {ref} from "vue";
import Button from "../Button.vue";
import {Fetch} from "../../api/Fetch.js";

const props = defineProps({
  quest: Object
})
const name = ref(props.quest.name)
const short_intro = ref(props.quest.short_intro)
const age_limit = ref(props.quest.age_limit)
const human_count = ref(props.quest.human_count)
const time = ref(props.quest.time)
const level_difficulty = ref(props.quest.level_difficulty)
const price = ref(props.quest.price)
const descriptions = ref(props.quest.descriptions)
const img = ref(props.quest.image)
const image = ref('')

const emits = defineEmits(['editQuest'])
const uploadFile = (event) => {
  image.value = event.target.files[0]

  if (!FileReader) {
    alert('FileReader не поддерживается — облом');
    return;
  }
  const fileReader = new FileReader();

  fileReader.onload = function() {
    img.value = fileReader.result;
  }
  fileReader.readAsDataURL(event.target.files[0]);


}
const notice = ref('')
const editQuest = async () => {
  const data = {
    method: 'editQuest',
    name: name.value,
    short_intro: short_intro.value,
    age_limit: age_limit.value,
    human_count: human_count.value,
    time: time.value,
    level_difficulty: level_difficulty.value,
    price: price.value,
    descriptions: descriptions.value,
    image: image.value,
    id: props.quest.id
  }
  const res = await Fetch(data)
  if (+res) {
    notice.value = {text: 'Квест успешно изменён', status: 'success'}
    emits('editQuest',{...data, image: image.value.name} )
  }
}

</script>

<template>
  <Modal class="ModalQuest" :notice="notice" @closeNotice="notice=''">
    <div  class="ModalAddQuest">
      <h2>Изменение квеста</h2>
      <img :src="image === '' ? 'questSite/src/imageQuests/' + img : img" alt="">
      <input v-model="name" type="text" placeholder="Название"/>
      <input v-model="short_intro" type="text" placeholder="Краткое описание"/>
      <input v-model="age_limit" type="number" placeholder="Возрастное ограничение"/>
      <input v-model="human_count" type="text" placeholder="Количество возможных игроков"/>
      <input v-model="time" type="text" placeholder="Время нужное для прохождения"/>
      <input v-model="level_difficulty" type="number" placeholder="Уровень сложности"/>
      <input v-model="price" type="number" placeholder="Строимость квеста"/>
      <textarea rows="5" v-model="descriptions" type="text" placeholder="Описание"/>
      <input @change="uploadFile" type="file" placeholder="Описание"/>
      <Button @click="editQuest">Изменить</Button>
    </div>

  </Modal>
</template>
<style>
.ModalQuest .content-modal {
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
  overflow: auto;
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