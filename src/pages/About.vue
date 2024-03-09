
<script setup>

import SliderAbout from "../components/SliderAbout.vue";



</script>
<template>
    <div class="About">
        <div class="aboutImg"></div>
        <div class="about">
            <h1>О нас</h1>

            <p>Мы являемся оффициальной компанией на территории стран РФ. В ассортименте интернет-магазина вы найдете все необходимое для выгодной струйной печати. Среди наших покупателей родители школьников и студентов, которые ищут возможность для бюджетной печати учебных материалов. Также мы сотрудничаем с крупными компаниями, которые печатают на заказ – фото на холсте, логотипы на футболках, рекламные материалы для наружного размещения.</p>
            <div>
                <div>
                    <h1>18+</h1>
                    <p>Лет опыта торговли</p>
                </div>
                <div>
                    <h1>10000+</h1>
                    <p>Довольних клиентов</p>
                </div>
            </div>

            <ul>


            </ul>
        </div>
        <SliderAbout/>

        <div class="about2 about">
            <h2>Основные группы товаров, с которыми мы работаем:</h2>
            <ul>
                <li>Струйные принтеры, МФУ и плоттеры из разных ценовых категорий – все виды техники вы получаете с гарантией от 12 до 18 месяцев.</li>
                <li>СНПЧ – системы непрерывной подачи чернил, которые до 30 раз сокращают траты на расходные материалы.</li>
                <li>Одноразовые оригинальные и совместимые картриджи, а также ПЗК для многоразового использования.</li>
                <li>Чернила для печати фото, сублимации, наружной рекламы и работы с широким спектром материалов.</li>
                <li>Бумага для фото, создания текстовых документов, сублимации, широкоформатной печати.</li>
                <li>Комплектующие и аксессуары для разных видов ПУ, включая широкоформатные.</li>
            </ul>
        </div>
    </div>


<!--  <Slider/>-->
</template>

<style scoped lang="scss">

@import "https://fonts.fontstorage.com/import/abeezee.css";
@import "../App";
.aboutImg {
    background: url("src/assets/product/about.avif") no-repeat;
    background-size: contain;
    height: 0;
    padding-top:32%;
    width: 100%;
}
.About {
    width: 100%;
    min-height: 1600px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}
.about2 {
    gap: 10px !important;
}
.about {
    display: flex;
    flex-direction: column;
    gap: 30px;
    width: 80%;
    padding: 10px;
    h1 {
        font-size: 55px;
    }
    > p {
        font-size: 20px;
    }
    h2 {
        font-size: 30px;
    }
    li {
        font-size: 20px;
        color: #424040;
        margin-left: 50px;
    }
    > div {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 30px;
        > div {
            text-align: center;
            h1 {
                font-weight: 500;
                font-size: 60px;
                color: $dopColor;
            }
            p {
                font-family: AABeeZee, italic;
                letter-spacing: 1.3px;
                font-weight: bold;
                font-size: 20px;
            }
        }
    }
}

@media (width < 800px) {
    .about {
        h1 {
            font-size: 35px;
        }
        p {
            font-size: 15px;
        }
    }
    .about2 {
        h2 {
            font-size: 20px;
        }
        li {
            font-size: 15px;
        }
    }

}


@media (width < 500px) {
    .aboutImg {
        background: url("src/assets/product/aboutmobile.avif") no-repeat;
        background-size: 100% 100%;
    }
    .about {
        width: 100%;
         > div {
             h1 {
                 font-size: 45px !important;
             }
            p {
                font-size: 15px !important;
            }
         }
    }


}
</style>