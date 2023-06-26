<template>
    <div class="box-relative">

        <Head_component
            :brad="object.name"
            :brad-link="true"
            brad-link-to="chooseObject"
            brad-link-to-title="Вернуться к объектам"
            :is-opacity="true"
        ></Head_component>

        <div id="c" class="main-img-container" >
            <div class="govno">
                <div id="h" class="drag-block">
                    <svg class="svg-maket" :viewBox="object.viewBox">
                        <g v-for="house in houses">
                            <router-link v-if="house.img !== null" :to="{name: 'chooseFloor', params: {id: house.id}}">
                                <path class="part" :d="house.coordinates" @mousemove="mouseOver(house)" @mouseleave="mouseLeave()"></path>
                            </router-link>

                            <path v-if="house.img === null" class="part" :d="house.coordinates" @mousemove="mouseOver(house)" @mouseleave="mouseLeave()"></path>

                        </g>
                    </svg>

                    <img class="img-maket" :src="object.img" >
                </div>
            </div>
            <div id="pointer1" class="box-pointer box-pointer-hidden house">
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

        </div>

        <div style="position: fixed; top: 85%; left: 45%; z-index: 1050">
            <v-btn :elevation="5" @click="$router.push({name: 'flatList', params: {pSelectObject: [object.id] }})">
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
                axios.get('/api/objects/' + this.$route.params.id)
                    .then(response=>{
                        if (response.data.object.type === 'tc'){
                            this.$router.push('/404');
                        }
                        this.object = response.data.object
                        this.houses = response.data.object.houses
                    })
                    .catch(error=>{
                        if(error.response.status === 404){
                            this.$router.push('/404');
                        }
                    })
            },
            mouseOver(house){
                var pointerElem = document.getElementById('pointer1');

                this.boxHouseName = house.name;
                this.boxHouseFlats = house.empty_flats;
                this.boxHouseStatus = house.description;

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

        }
    }
</script>

<style scoped>
</style>

