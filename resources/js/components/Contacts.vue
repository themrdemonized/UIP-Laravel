<template>
    <div class="contacts" style="position: relative">

        <Head_component
            title="Контакты"
            :isContrast="true"
        ></Head_component>

<!--        <div class="plan-head plan-head-contacts">-->
<!--            <div class="plan-head-left">-->
<!--                <div class="plan-head-left-brad">-->
<!--                      <span>-->
<!--                           Новые грани города-->
<!--                      </span>-->
<!--                </div>-->
<!--                <div class="plan-head-left-descr">-->
<!--                        <span>-->
<!--                            Контакты-->
<!--                        </span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="plan-head-right">-->
<!--                <div style="display: flex">-->
<!--                    <div class="plan-head-right-contacts" style="margin-right: 1rem;">-->
<!--                        <a title='Отдел продаж ЖК "Петроглиф парк"' href="tel:+7 (4212) 413-413">+7(4212)413-413</a>-->
<!--                    </div>-->
<!--                    <div class="plan-head-right-contacts">-->
<!--                        <a title='Отдел продаж ЖК "Восточный парк"' href="tel:+7 (4212) 413-414">+7(4212)413-414</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="plan-head-right-span">-->
<!--                    <span @click="showModal()">Заказать звонок</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div class="contact-box">
            <div class="contact-box-numb">
                <div class="contact-box-numb-c">
                    <div class="contact-box-numb-c-title">
                        <h4>Отдел продаж ЖК "Петроглиф парк"</h4>
                    </div>
                    <div class="contact-box-numb-c-middle">
                        <div class="contact-box-numb-c-middle-numb">
                            <h5>Номер</h5>
                            <a href="tel:+7 (4212) 413-413">+7 (4212) 413-413</a>
                        </div>
                        <div class="contact-box-numb-c-middle-email">
                            <h5>Email</h5>
                            <a href="mailto:413413@uip-dv.ru">413413@uip-dv.ru</a>
                        </div>
                    </div>
                    <div class="contact-box-numb-c-bottom">
                        <div class="contact-box-numb-c-bottom-adr">
                            <h5>Адрес</h5>
                            <span>ул. Краснореченская 225/1</span> <br>
                            <span>(находится на территории стройплощадки)</span>
                        </div>
                        <div class="contact-box-numb-c-bottom-work">
                            <h5>График работ</h5>
                            <span>пн - пт 9-00 до 18-00 <br> сб 10-00 до 14-00</span>
                        </div>
                    </div>

                </div>
                <div class="contact-box-numb-c">
                    <div class="contact-box-numb-c-title">
                        <h4>Отдел продаж ЖК "Восточный парк"</h4>
                    </div>
                    <div class="contact-box-numb-c-middle">
                        <div class="contact-box-numb-c-middle-numb">
                            <h5>Номер</h5>
                            <a href="tel:+7 (4212) 413-414">+7 (4212) 413-414</a>
                        </div>
                        <div class="contact-box-numb-c-middle-email">
                            <h5>Email</h5>
                            <a href="mailto:413414@uip-dv.ru">413414@uip-dv.ru</a>
                        </div>
                    </div>
                    <div class="contact-box-numb-c-bottom">
                        <div class="contact-box-numb-c-bottom-adr">
                            <h5>Адрес</h5>
                            <span>ул. Карла Маркса 146 Б</span> <br>
                            <span>(находится на территории стройплощадки)</span>
                        </div>
                        <div class="contact-box-numb-c-bottom-work">
                            <h5>График работ</h5>
                            <span>пн - пт 9-00 до 18-00 <br> сб 10-00 до 14-00</span>
                        </div>
                    </div>

                </div>
                <div class="contact-box-numb-c">
                    <div class="contact-box-numb-c-title">
                        <h4>Центральный офис, приемная</h4>
                    </div>
                    <div class="contact-box-numb-c-middle">
                        <div class="contact-box-numb-c-middle-numb">
                            <h5>Номер</h5>
                            <a href="tel:+7 (4212) 413-188">+7 (4212) 413-188</a>
                        </div>
                        <div class="contact-box-numb-c-middle-email">
                            <h5>Email</h5>
                            <a href="mailto:office@uip-dv.ru">office@uip-dv.ru</a>
                        </div>
                    </div>
                    <div class="contact-box-numb-c-bottom">
                        <div class="contact-box-numb-c-bottom-adr">
                            <h5>Адрес</h5>
                            <span>ул. Карла Маркса 146 Б</span> <br>
                            <span></span>
                        </div>
                        <div class="contact-box-numb-c-bottom-work">
                            <h5>График работ</h5>
                            <span>пн-пт 9-00 до 18-00 <br> (обед с 13 до 14)</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="contact-box-map">
                <div id="map"></div>
            </div>
        </div>

<!--        <div class="contact-box">-->
<!--            <div class="contacts-box">-->
<!--                <div class="contact">-->
<!--                    Отдел продаж ЖК "Петроглиф парк": <a href="tel:+7 (4212) 413-413">+7 (4212) 413-413</a>, <a-->
<!--                    href="mailto:413413@uip-dv.ru">413413@uip-dv.ru</a> <br>-->
<!--                    (находится на территории стройплощадки по ул. Шевчука 30 Б стр.1)-->
<!--                </div>-->
<!--                <br>-->
<!--                <div class="contact">-->
<!--                    Отдел продаж ЖК "Восточный парк": <a href="tel:+7 (4212) 413-414">+7 (4212) 413-414</a>, <a-->
<!--                    href="mailto:413414@uip-dv.ru">413414@uip-dv.ru</a> <br>-->
<!--                    (находится на территории стройплощадки по ул. Карла Маркса 146 Б) <br> <br>-->
<!--                    Режим работы: пн - пт 9-00 до 18-00, сб 10-00 до 14-00-->
<!--                </div>-->
<!--                <br>-->
<!--                <div>-->
<!--                    Центральный офис приемная: <a href="tel:+7 (4212) 413-188">+7 (4212) 413-188</a>,-->
<!--                    <a href="mailto:office@uip-dv.ru">office@uip-dv.ru</a> <br>-->
<!--                    (находится по адресу 680000 г. Хабаровск, ул. Гайдара, 14 <br>-->
<!--                    Режим работы: пн-пт 9-00 до 18-00 (обед с 13-00 до 14-00)-->
<!--                </div>-->

<!--            </div>-->

<!--        </div>-->
    </div>
</template>

<script>
    import Head_component from "./layout/HeadComponent";
    export default {
        name: "Contacts",
        components: {Head_component},
        methods:{
            showModal(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            },
            initMap(){
                ymaps.ready(init);

                function init(){
                    var myMap = new ymaps.Map("map", {
                        center: [48.48181973371742,135.1017567130199],
                        zoom: 13,
                        controls: []
                    }, {
                        suppressMapOpenBlock: true,
                    });

                    // myMap.behaviors.disable('scrollZoom')

                    var myGeoObject1 = new ymaps.Placemark([48.455416422061575,135.0996286355819], {
                        // hintContent: 'Петроглиф парк',
                        iconCaption: 'Отдел продаж ЖК "Петроглиф парк"'
                    });

                    var myGeoObject2 = new ymaps.Placemark([48.50369172168796,135.11432140347043], {
                        iconCaption: 'Отдел продаж ЖК "Восточный парк"'
                    });

                    var myGeoObject3 = new ymaps.Placemark([48.487408716171494,135.0716767123031], {
                        iconCaption: 'Центральный офис, приемная'
                    });

                    // Размещение геообъекта на карте.
                    myMap.geoObjects
                        .add(myGeoObject1)
                        .add(myGeoObject2)
                        .add(myGeoObject3);
                }
            },
        },
        mounted() {
            this.initMap();
        }
    }
</script>

<style scoped>

</style>

