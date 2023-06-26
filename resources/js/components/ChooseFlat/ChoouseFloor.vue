<template>
    <div style="position: relative; height: 100vh">

        <Head_component
            :brad="brad"
            :brad-link="true"
            :brad-link-to="linkTo"
            :brad-link-to-title="linkName"
            :is-shadow="true"
            :is-light="true"
            :brad-link-params="bradLinkParams"
        ></Head_component>

        <div class="choose-floor-box">
            <div class="choose-floor-tabs-head">
                <div class="tabs-head-title" :class="{'active' : activeCategory === 1}" @click="activeCategory = 1">Выбрать этаж</div>
                <div class="tabs-head-title" v-if="house.info !== null" :class="{'active' : activeCategory === 2}" @click="activeCategory = 2">О доме</div>
                <div class="tabs-head-title" v-if="reports.length > 0" :class="{'active' : activeCategory === 3}" @click="activeCategory = 3">Фотоотчеты</div>
                <div class="tabs-head-title" v-if="house.video !== null" :class="{'active' : activeCategory === 6}" @click="activeCategory = 6">Трансляция</div>
                <div class="tabs-head-title" :class="{'active' : activeCategory === 4}" @click="initMap">Расположение</div>
                <div class="tabs-head-title" v-if="docs.length > 0" :class="{'active' : activeCategory === 5}" @click="activeCategory = 5">Документы</div>
                <div class="tabs-head-title" v-if="banks.length > 0" :class="{'active' : activeCategory === 7}" @click="activeCategory = 7">Аккредитация</div>
            </div>
            <div class="choose-floor-tabs-body" >
                <div id="c" class="tab-body tabs-body-floor" v-show="activeCategory === 1">
                    <div class="govno">
                            <div id="h" class="drag-block">
                                <svg class="svg-maket" :viewBox="house.viewBox">
                                    <g v-for="floor in floors">
                                        <router-link :to="{name: 'chooseFlat', params: {id: floor.id, name: Number(floor.name) }}" :key="floor.coordinates">
                                            <path :class="{'active' : floor.empty_flats > 0 || floor.empty_offices > 0 || floor.empty_pantries > 0}" class="part" :d="floor.coordinates"  @mousemove="mouseOver(floor)" @mouseleave="mouseLeave()"></path>
                                        </router-link>
                                    </g>
                                </svg>
                                <img class="img-maket" :src="house.img" >
                            </div>
                        </div>
                </div>
                <div id="pointer1" class="box-pointer box-pointer-hidden" style="height: 50px;">
                    <div class="box-pointer-head">
                        <div class="box-pointer-head-left">
                            <span class="box-pointer-head-number">{{boxHouseFloor}}</span>
                            <span class="box-pointer-head-descr">этаж</span>
                        </div>
                        <div v-if="boxHouseEmptyPantries === 0 && boxHouseEmptyOffices === 0" class="box-pointer-head-right">
                            <span class="box-pointer-head-number">{{boxHouseEmptyFlats}}</span>
                            <span v-if="boxHouseEmptyFlats===1" class="box-pointer-head-descr">квартира</span>
                            <span v-if="boxHouseEmptyFlats>=2 && boxHouseEmptyFlats<=4" class="box-pointer-head-descr">квартиры</span>
                            <span v-if="boxHouseEmptyFlats>=5 || boxHouseEmptyFlats===0" class="box-pointer-head-descr">квартир</span>
                        </div>
                        <div v-else-if="boxHouseEmptyFlats === 0 && boxHouseEmptyOffices === 0" class="box-pointer-head-right">
                            <span class="box-pointer-head-number">{{boxHouseEmptyPantries}}</span>
                            <span v-if="boxHouseEmptyPantries===1" class="box-pointer-head-descr">кладовка</span>
                            <span v-if="boxHouseEmptyPantries>=2 && boxHouseEmptyPantries<=4" class="box-pointer-head-descr">кладвоки</span>
                            <span v-if="boxHouseEmptyPantries>=5 || boxHouseEmptyPantries===0" class="box-pointer-head-descr">кладовок</span>
                        </div>
                        <div v-else-if="boxHouseEmptyFlats === 0 && boxHouseEmptyPantries === 0" class="box-pointer-head-right">
                            <span class="box-pointer-head-number">{{boxHouseEmptyOffices}}</span>
                            <span v-if="boxHouseEmptyOffices===1" class="box-pointer-head-descr">офис</span>
                            <span v-if="boxHouseEmptyOffices>=2 && boxHouseEmptyOffices<=4" class="box-pointer-head-descr">офиса</span>
                            <span v-if="boxHouseEmptyOffices>=5 || boxHouseEmptyOffices===0" class="box-pointer-head-descr">офисов</span>
                        </div>
                    </div>
                </div>


                <div class="tab-body tabs-body-about" v-show="activeCategory === 2">
                    {{house.info}}
                </div>
                <div class="tab-body tabs-body-photo" v-show="activeCategory === 3">
                        <div class="photo-report-card-box" v-for="report in reports" :key="report.title">
                            <div class="photo-report-card">
                                    <viewer class="photo-report-img" :images="report.photo" :options="options">
                                        <img v-for="photo in report.photo" :class="{'active' : photo === report.photo[0]}" :src="'/' + photo.path" :key="photo.path">
                                    </viewer>
                                    <div class="photo-report-title">{{report.title}}</div>
                            </div>
                        </div>
                </div>
                <div class="tab-body tabs-body-place" v-show="activeCategory === 4">
                    <div id="map"></div>
                </div>
                <div class="tab-body tabs-body-docs"  v-show="activeCategory === 5">
                    <div class="doc-col" v-for="doc in docs" :key="doc.name">
                        <a class="doc-link" :href="'/' + doc.path" target="_blank">
                            <div class="doc-icon"><v-icon style="font-size: 5rem">mdi-file-pdf</v-icon></div>
                            <div class="doc-info">
                                <div class="doc-name">{{doc.name}}</div>
                                <div class="doc-release">
                                    <div class="doc-date">Дата размещения документа: {{doc.date}};</div>
                                    <div class="doc-user">Ответсвенный: {{doc.user_name}}</div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
                <div class="tab-body tabs-body-video"  v-show="activeCategory === 6">
                    <iframe width="100%" height="100%" :src="house.video" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="tab-body tabs-body-banks"  v-show="activeCategory === 7">
                    <div class="house-bank" v-for="bank in banks">
                        <a class="house-bank__link" :href="bank.link">
                            <img class="house-bank__img" :src="bank.img" :alt="bank.name">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import {gsap} from 'gsap'
    import {Draggable} from 'gsap/Draggable'
    import Head_component from "../layout/HeadComponent";

    gsap.registerPlugin(Draggable);

    export default {
        name: "ChoouseFloor",
        components: {Head_component},
        data(){
            return{
                options:{
                    "title": false,
                    "scalable": false,
                },
                house: [],
                floors: [],
                docs: [],
                reports: [],
                banks: [],
                objectName: '',
                boxHouseFloor: null,
                boxHouseEmptyFlats: null,
                boxHouseEmptyOffices: null,
                boxHouseEmptyPantries: null,
                bradLinkParams: {},
                type: null,
                activeCategory: 1,
            }
        },
        computed:{
            brad : function () {
                if(this.type === 'tc'){
                    return '' + this.objectName
                }
                return this.objectName + ' - Дом ' + this.house.name
            },
            linkTo : function ( ) {
                if (this.type === 'tc'){
                    return 'chooseObject'
                }

                return 'chooseHouse'
            },
            linkName : function ( ) {
                if (this.type === 'tc'){
                    return 'Вернуться к объектам'
                }

                return 'Вернуться к жилому комплексу'
            }
        },
        methods:{
            fetch(){
                axios.get('/api/houses/' + this.$route.params.id)
                    .then(response=>{
                        this.house = response.data.house
                        this.floors = response.data.floors
                        this.type = response.data.house.object.type
                        this.docs = response.data.docs
                        this.reports = response.data.reports
                        this.banks = response.data.banks
                        this.objectName = response.data.house.object.name
                        this.bradLinkParams['id'] = response.data.house.object_id
                    })
                    .catch(error=>{
                        if(error.response.status === 404){
                            this.$router.push('/404');
                        }
                    })
            },
            mouseOver(floor){
                var pointerElem = document.getElementById('pointer1');

                this.boxHouseFloor = floor.name;
                this.boxHouseEmptyFlats = floor.empty_flats;
                this.boxHouseEmptyOffices = floor.empty_offices;
                this.boxHouseEmptyPantries = floor.empty_pantries;

                var mouseX = event.pageX;
                var mouseY = event.pageY;

                if (pointerElem.classList.contains('box-pointer-hidden')) {
                    pointerElem.classList.remove('box-pointer-hidden');
                }

                pointerElem.style.transform = 'translate3d(' + mouseX + 'px, ' + mouseY + 'px, 0px)';
            },
            mouseLeave(){
                var pointerElem = document.getElementById('pointer1');
                pointerElem.classList.add('box-pointer-hidden');
            },

            initDrag(){
                Draggable.create("#h", {
                    type: "x,y",
                    bounds: document.getElementById("c"),
                })
            },
            initMap(){
                ymaps.ready(init(this.house.object_id) );
                this.activeCategory = 4;

                function init(house){
                    var myMap = new ymaps.Map("map", {
                        center: [48.481570300322154,135.07875002750023],
                        zoom: 13,
                        controls: []
                    }, {
                        suppressMapOpenBlock: true,
                    });

                    myMap.controls.add('zoomControl');

                    var searchControl = new ymaps.control.SearchControl({
                        options: {
                            position: { left: 20, bottom: 20 }
                        }
                    });
                    myMap.controls.add(searchControl);

                    if(house === 2){
                        var myGeoObject1 = new ymaps.Placemark([48.455416422061575,135.0996286355819], {
                            iconCaption: 'Петроглиф парк'
                        });

                        myMap.geoObjects
                            .add(myGeoObject1);
                    }

                    if(house === 1) {
                        var myGeoObject2 = new ymaps.Placemark([48.50369172168796, 135.11432140347043], {
                            iconCaption: 'Восточный парк'
                        });
                        // Размещение геообъекта на карте.
                        myMap.geoObjects
                            .add(myGeoObject2);
                    }
                }
            },
        },
        created() {
            this.fetch();
        },
        mounted(){
            // this.initDrag()
        },
    }
</script>

<style scoped>
    body{
        margin: 0;
        padding: 0;
    }
</style>
