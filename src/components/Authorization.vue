

<script setup>


import Modal from "./Modal.vue";
</script>

<template>
    <Modal>
        <div class="authorization">
            <h2>Авторизация</h2>
            <div>
                <input placeholder="Имя пользователя" type="text">
                <input placeholder="Пароль" type="password">
            </div>

            <button @click="authorization" >Войти</button>
        </div>

    </Modal>
</template>

<style scoped lang="scss">
@import "../App";
.authorization {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 20px;
    > div {
        display: flex;
        flex-direction: column;
        gap: 15px;
        > div {
            align-items: center;
            justify-content: space-between;
            display: flex;
            gap: 10px;

            p {

            }
        }

    }
    input {
        height: 40px;
        border-radius: 10px;
        padding: 5px 15px;
        background-color: #c9c8c8;
        outline: none;
        border: none;
        transition: all 0.15s ease;
        font-size: 15px;
        &:focus {
            background-color: #ffffff;
            box-shadow: 0 0 0 3px #2365c2;
        }
    }
    button {
        margin: 10px auto 0 auto;
        width: fit-content;
        padding: 8px 25px;
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

}
</style>