<template>
    <div>
        <div class="box-opacity" @click="hideBoxClick">
            <div class="box-opacity-center">
                <div class="box-opacity-icon">
                    <v-icon size="46" class="theme--dark">mdi-hand-left</v-icon>
                </div>
                <div class="box-opacity-descr">
                    Зажмите и потяните карту <br>
                    для выбора объекта
                </div>
            </div>
        </div>

        <div class="box-choose-object">
            <head_component
                title="Объекты УИП"
                :is-shadow="true"
                :is-light="true"
            ></head_component>
            <div class="box-choose-body">
                <div id="map"></div>
            </div>
        </div>

    </div>
</template>

<script>
    import Head_component from "../layout/HeadComponent";
    export default {
        name: "ChooseObject",
        components: {Head_component},
        data(){
            return{
                objects:[
                    {id: 1, name: 'Восточный парк', coords: ''},
                    {id: 2, name: 'Петроглиф парк', coords: ''}
                ]
            }
        },
        methods:{
            a(){
                window.location.href = "chooseHouse/2";
            },
            b(){
                this.$router.push({ path: 'chooseHouse/1' })
            },
            hideBoxClick(){
                document.querySelector('.box-opacity').classList.add('hide');
            },
            hideBoxTimer(){
                function hide() {
                    document.querySelector('.box-opacity').classList.add('hide')
                }

                setTimeout(hide, 3000);
            },
            initMap(){
                ymaps.ready(init);

                function init(){
                    var myMap = new ymaps.Map("map", {
                        center: [48.481570300322154,135.07875002750023],
                        zoom: 13
                    });

                    // myMap.behaviors.disable('scrollZoom')

                    var myGeoObject1 = new ymaps.Placemark([48.455416422061575,135.0996286355819], {
                        // hintContent: 'Петроглиф парк',
                        iconCaption: 'Петроглиф парк'
                    });

                    var myGeoObject2 = new ymaps.Placemark([48.50369172168796,135.11432140347043], {
                        iconCaption: 'Восточный парк'
                    });

                    myGeoObject1.events.add('click', function () {
                        window.location.href = "houses/2";
                    });

                    myGeoObject2.events.add('click', function () {
                        window.location.href = "houses/1";
                        // this.$router.push({ path: 'chooseHouse/1' })
                    });

                    // Размещение геообъекта на карте.
                    myMap.geoObjects
                        .add(myGeoObject1)
                        .add(myGeoObject2);
                }
            },
            showModal(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            },
        },
        mounted(){
            this.initMap();
            this.hideBoxTimer();

        },
        updated() {
            console.log('ky')
        }
    }
</script>

<style scoped>

</style>
