<template>
    <div class="box-relative">

        <Head_component
            :brad="object.name"
            :brad-link="true"
            brad-link-to="chooseObject"
            brad-link-to-title="Вернуться к объектам"
            :is-opacity="true"
        ></Head_component>

        <div id="pointer1" class="box-pointer box-pointer-hidden">
                        <div class="box-pointer-head">
                            <div class="box-pointer-head-left">
                                <span class="box-pointer-head-number">{{boxHouseName}}</span>
                                <span class="box-pointer-head-descr">дом</span>
                            </div>
                            <div class="box-pointer-head-right">
                                <span class="box-pointer-head-number">{{boxHouseFlats}}</span>
                                <span class="box-pointer-head-descr">квартир</span>
                            </div>
                        </div>
                        <div class="box-pointer-body">
                            <div>
                                {{boxHouseStatus}}
                            </div>
                        </div>
                        <div class="box-pointer-bottom">

                        </div>
                    </div>

        <div id="c" class="main-img-container" >
            <div class="govno">
                <div id="h" class="drag-block">
                    <svg class="svg-maket" :viewBox="object.viewBox">
                        <g v-for="house in houses">
                            <router-link :to="{name: 'chooseFloor', params: {id: house.id}}">
                                <path class="part" :d="house.coordinates" @mouseover="houseInfo($event, house)"></path>
                            </router-link>
                        </g>
                    </svg>

                    <img class="img-maket" :src="object.img" >
                </div>
            </div>
        </div>

        <div style="position: absolute; top: 85%; left: 45%; z-index: 1050">
                        <v-btn :elevation="5" @click="$router.push({name: 'flatList', params: {pSelectObject: object.id}})">
                            Выбрать по параметрам
                        </v-btn>
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
        components: {Head_component},
        data(){
            return{
                object: [],
                houses: [],
                house: [],
                floors: [],
                boxHouseName: null,
                boxHouseFlats: null,
                boxHouseStatus: null,


                loading: false,
            }
        },
        mounted(){
            Draggable.create("#h", {
                type: "x,y",
                bounds: document.getElementById("c"),
            })
        },
        created(){
            this.fetch()
        },
        methods:{
            fetch(){
                this.$http.get('/api/objects/' + this.$route.params.id)
                    .then(response=>{
                        this.object = response.data.object
                        this.houses = response.data.object.houses
                    })
            },

            houseInfo(event,house){
                'use strict';

                var boxElem = event.currentTarget;
                var pointerElem = document.getElementById('pointer1');
                this.boxHouseName = house.name;
                this.boxHouseFlats = house.empty_flats;
                this.boxHouseStatus = house.description;

                function onMouseMove(event) {
                    var mouseX = event.pageX;
                    var mouseY = event.pageY;
                    var crd = boxElem.getBoundingClientRect();

                    var activePointer = crd.left <= mouseX && mouseX <= crd.right && crd.top <= mouseY && mouseY <= crd.bottom;

                    if (crd.left <= mouseX && mouseX <= crd.right && crd.top <= mouseY && mouseY <= crd.bottom) {
                        if (pointerElem.classList.contains('box-pointer-hidden')) {
                            pointerElem.classList.remove('box-pointer-hidden');
                        }

                        pointerElem.style.transform = 'translate3d(' + mouseX + 'px, ' + mouseY + 'px, 0px)';

                    } else {
                        pointerElem.classList.add('box-pointer-hidden');
                    }
                }

                function disablePointer() {
                    requestAnimationFrame(function hidePointer() {
                        pointerElem.classList.add('box-pointer-hidden');
                    });
                }

                boxElem.addEventListener('mousemove', onMouseMove, false);
                boxElem.addEventListener('mouseleave', disablePointer, false);
            },
        }
    }
</script>

<style scoped>
</style>

