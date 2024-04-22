<script setup>
import { CgProfile, BxTimeFive, TaLockCog ,  ReDeleteBinLine, ClEditPencil01  } from "@kalimahapps/vue-icons";
import Button from "../../components/Button.vue";
import {computed, onMounted, ref} from "vue";
import {Fetch} from "../../api/Fetch.js";
import ModalAddQuest from "../../components/modal/ModalAddProduct.vue";
import ModalEditQuest from "../../components/modal/ModalEditProduct.vue";

const data = ref([])
const visibleModal = ref('')
const deleteQuest = async (id) => {
  const res = await Fetch({method: 'deleteQuest',  id})
  if (res) data.value = data.value.filter(el => el.id !== id)
}
const changeQuest = (changeData) => {
  data.value = data.value.map(el => el.id === changeData.id ? changeData : el)
}
const addQuest = (quest) => {
  data.value.push({...quest, id: data.value.length - 1})
}
const editQuestId = ref('')
const editQuestFunc = computed(() => data.value.filter(el => el.id === editQuestId.value)[0])
onMounted( async() => {
  data.value = await Fetch({method: 'getQuests'})
})
</script>

<template>
  <div class="Quests">
    <Button @click="visibleModal='addQuest'">Добавить новый квест</Button>
    <div class="table">
      <table>
        <tr>
          <th>Номер</th>
          <th>Название</th>
          <th>Интро</th>
          <th>Возрастное ограничение</th>
<!--          <th>Рейтинг</th>-->
          <th>На сколько человек</th>
          <th>Время прохождения</th>
          <th>Уровень сложности</th>
          <th>Стоимость</th>
          <th>Фото</th>
          <th>Действия</th>
        </tr>
        <tr v-for="el of data" :key="el.id" >
          <td>{{el.id}}</td>
          <td>{{el.name}}</td>
          <td>{{el.short_intro}}</td>
          <td>{{el.age_limit}}+</td>
<!--          <td>{{el.rating_num}}</td>-->
          <td><CgProfile/> <span>{{el.human_count}} чел.</span></td>
          <td><BxTimeFive/> <span>{{el.time}} мин.</span></td>
          <td><TaLockCog /><span> {{el.level_difficulty}}/10</span></td>
          <td>{{el.price}}₽</td>
          <td><img :src="'questSite/src/imageQuests/' + el.image" alt=""></td>
          <td class="button"><Button @click="deleteQuest(el.id)" class="red"><ReDeleteBinLine/></Button><Button @click="() => {editQuestId = el.id; visibleModal='editQuest'}"><ClEditPencil01/></Button></td>
        </tr>
      </table>
    </div>
    <transition name="modalBooking" duration="350">
      <ModalAddQuest @add-quest="addQuest"  @close="visibleModal = ''" v-if="visibleModal === 'addQuest'"/>
      <ModalEditQuest @edit-quest="changeQuest"  @close="visibleModal = ''" v-else-if="visibleModal === 'editQuest'" :quest="editQuestFunc"/>
    </transition>

<!--    <ModalEditUser @close="modalEditUser = false" v-if="modalEditUser" :user="EditUser" :change-user="changeUser"/>-->
  </div>
</template>

<style scoped lang="scss">
@import "../../App";
.Quests {
  display: flex;
  flex-direction: column;
  gap: 15px;
  .table {
    @include table;
    .red {
      margin-right: 3px;
    }
    img {
      width: 150px;
    }
    td {
      > * {
        vertical-align: middle;
        color: white;
      }
      span {
        padding-left: 3px ;
      }
      max-width: 200px;
    }

  }
}
</style>