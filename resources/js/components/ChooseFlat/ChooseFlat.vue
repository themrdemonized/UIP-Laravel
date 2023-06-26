<template>
    <div>

        <div v-if="offices.length > 0" id="pointer_office" class="box-pointer box-pointer-hidden house" style="width: 12rem">
            <div class="box-pointer-head">
                <div class="box-pointer-head-left">
                    <span class="box-pointer-head-number">{{boxFlatName}}</span>
                    <span class="box-pointer-head-descr">офис</span>
                </div>
                <div class="box-pointer-head-right">
                    <span class="box-pointer-head-number">{{boxFlatArea}}</span>
                    <span class="box-pointer-head-descr">м<sup>2</sup></span>
                </div>
            </div>
            <div class="box-pointer-body">
                <div class="box-pointer-body-coast">{{boxFlatCoast}} ₽ / мес</div>
            </div>
        </div>
        <div v-if="pantries.length > 0" id="pointer_pantry" class="box-pointer box-pointer-hidden " style="width: 12rem">
            <div class="box-pointer-head">
                <div class="box-pointer-head-left">
                    <span class="box-pointer-head-number">{{boxFlatName}}</span>
                    <span class="box-pointer-head-descr">кладовая</span>
                </div>
                <div class="box-pointer-head-right">
                    <span class="box-pointer-head-number">{{boxFlatArea}}</span>
                    <span class="box-pointer-head-descr">м<sup>2</sup></span>
                </div>
            </div>
            <div class="box-pointer-body">
                <div class="box-pointer-body-coast">{{boxFlatCoast}} ₽</div>
            </div>
        </div>
        <div v-if="flats.length > 0" id="pointer1" class="box-pointer box-pointer-hidden house" style="width: 12rem">
            <div class="box-pointer-head">
                <div class="box-pointer-head-left">
                    <span class="box-pointer-head-number">{{boxFlatName}}</span>
                    <span class="box-pointer-head-descr">квартира</span>
                </div>
                <div class="box-pointer-head-right">
                    <span class="box-pointer-head-number">{{boxFlatRooms}}</span>
                    <span v-if="boxFlatRooms === 1" class="box-pointer-head-descr">комната</span>
                    <span v-if="boxFlatRooms >= 2 && boxFlatRooms <= 4" class="box-pointer-head-descr">комнаты</span>
                    <span v-if="boxFlatRooms >= 5" class="box-pointer-head-descr">комнат</span>
                </div>
            </div>
            <div class="box-pointer-body">
                <div class="box-pointer-body-area">{{boxFlatArea}} м<sup>2</sup></div>
                <div class="box-pointer-body-coast">{{boxFlatCoast}} ₽</div>
            </div>
        </div>

        <div class="box-relative">

            <Head_component
                :brad="brad"
                :brad-link="true"
                :is-light="true"
                :is-shadow="true"
                brad-link-to="chooseFloor"
                brad-link-to-title="Вернуться к выбору этажа"
                :brad-link-params="bradLinkParams"
            ></Head_component>

            <div class="floor-body">
                <div class="floor-body-main">
                    <div class="floor-body-main-img">
                        <svg class="svg-maket svg-floor" :viewBox="floor.viewBox">
                            <g v-if="flats.length > 0" v-for="flat in flats" :key="flat.coordinates">
                                <path
                                    class="flat-part"
                                    v-if="flat.status_id === 1"
                                    :d="flat.coordinates"
                                    @mousemove="mouseOver('flat', flat)"
                                    @mouseleave="mouseLeave('flat')"
                                    @click="goToFlat(flat.id)"
                                ></path>
                                <path
                                    v-else="flat.status_id === 2"
                                    class="sold-part"
                                    :d="flat.coordinates"
                                ></path>
                                <text
                                    v-if="flat.status_id === 2"
                                    :dx="flat.dx"
                                    :dy="flat.dy"
                                    fill="#fff"
                                    font-family="Verdana, serif"
                                    font-size="34px"
                                >Продана</text>
                            </g>
                            <g v-if="offices.length > 0" v-for="office in offices" :key="office.coordinates">
                                <path
                                    v-if="office.status_id === 1"
                                    class="flat-part"
                                    :d="office.coordinates"
                                    @mousemove="mouseOver('office', office)"
                                    @mouseleave="mouseLeave('office')"
                                    @click="showModal('офис', office.id, office.name)"
                                ></path>
                                <path
                                    v-else="office.status_id === 2"
                                    class="sold-part"
                                    :d="office.coordinates"
                                ></path>
                                <text
                                    v-if="office.status_id === 2"
                                    :dx="office.dx"
                                    :dy="office.dy"
                                    fill="#fff"
                                    font-family="Verdana, serif"
                                    font-size="34px"
                                >Сдан</text>
                            </g>
                            <g v-if="pantries.length > 0" v-for="pantry in pantries" :key="pantry.coordinates">
                                <path
                                    v-if="pantry.status_id === 1"
                                    class="flat-part"
                                    :d="pantry.coordinates"
                                    @mousemove="mouseOver('pantry', pantry)"
                                    @mouseleave="mouseLeave('pantry')"
                                    @click="showModal('кладовка', pantry.id, pantry.name)"
                                ></path>
                                <path
                                    v-else="pantry.status_id === 2"
                                    class="sold-part "
                                    :d="pantry.coordinates"
                                ></path>
                                <text v-if="pantry.status_id === 2"
                                      :dx="pantry.dx"
                                      :dy="pantry.dy"
                                      fill="#fff"
                                      font-family="Verdana, serif"
                                      font-size="34px"
                                >Продана</text>
                            </g>
                        </svg>

                        <img :src="floor.img" style="height: 100%;">
                    </div>
                </div>

                <div class="floor-body-floors">
                    <hooper ref="hpr" :vertical="true" style="height: 100%" :itemsToShow="15" :itemsToSlide="2" >
                        <slide v-for="floor in floors" :class="{ is_current: floor.id === currentFloor}" :key="floor.name+floor.id">
                            <div class="hooper-floor-info" @click="goToFloor(floor.id)">
                                <div class="hooper-floor-info-num">
                                    {{floor.name}}
                                </div>
                                <div class="hooper-floor-info-title">
                                    этаж
                                </div>
                                <div class="hooper-floor-info-empty">
                                    {{floor.flats_empty}} свободно
                                </div>
                            </div>
                        </slide>

                        <hooper-navigation slot="hooper-addons"></hooper-navigation>
                    </hooper>
                </div>
            </div>

            <reserve-component
                :object-reserve="this.objectToReserve"
                :object-id="this.objectToReserveId"
                :object-name="this.objectToReserveName"
            ></reserve-component>

        </div>
    </div>
</template>

<script>
    import axios from "axios"
    import { Hooper, Slide, Navigation as HooperNavigation } from 'hooper';
    import 'hooper/dist/hooper.css';
    import { mask } from 'vue-the-mask'
    import Head_component from "../layout/HeadComponent";
    import ReserveComponent from "../layout/ReserveComponent";


    export default {
        name: "ChooseFlat",
        directives:{
            mask,
        },
        components: {
            ReserveComponent,
            Head_component,
            Hooper,
            Slide,
            HooperNavigation
        },
        data(){
            return{
                houseName: '',
                objectName: '',
                floors: [],
                offices: [],
                pantries: [],
                currentFloor: null,
                floor: [],
                flats: [],
                boxFlatArea: '',
                boxFlatRooms: '',
                boxFlatCoast: '',
                boxFlatName: '',
                type: null,

                bradLinkParams: {},

                objectToReserve: '',
                objectToReserveId: null,
                objectToReserveName: null,
            }
        },
        computed:{
            brad : function () {
                if(this.type === 'tc'){
                    return this.objectName + ' - Этаж ' + this.floor.name
                }
                return this.objectName + ' - Дом ' + this.houseName + ' - Этаж ' + this.floor.name
            }
        },
        methods:{
            goToFlat(id){
              this.$router.push({name: 'flat', params: {id: id} })
            },
            goToFloor(id){
                if (id !== this.$route.params.id){
                    this.$router.push({ name: 'chooseFlat', params: { id: id } })

                    axios.get('/api/getFloor', {
                        params:{
                            floorId:id
                        }
                    })
                        .then(response=>{
                            this.houseName = response.data.houseName
                            this.floors = response.data.floors
                            this.floor = response.data.floor
                            this.currentFloor = response.data.floor.id
                            this.flats = response.data.floor.flatss
                            this.offices = response.data.offices
                            this.pantries = response.data.pantries
                            this.bradLinkParams['id'] = response.data.floor.house_id
                        })
                }
            },
            fetch(){
                axios.get('/api/getFloor', {
                    params:{
                        floorId:this.$route.params.id
                    }
                })
                    .then(response=>{
                        this.houseName = response.data.houseName
                        this.type = response.data.type
                        this.objectName = response.data.objectName
                        this.floors = response.data.floors
                        this.floor = response.data.floor
                        this.currentFloor = response.data.floor.id
                        this.flats = response.data.floor.flatss
                        this.offices = response.data.offices
                        this.pantries = response.data.pantries
                        this.bradLinkParams['id'] = response.data.floor.house_id

                    })
                    .catch(error=>{
                        if(error.response.status === 404){
                            this.$router.push('/404');
                        }
                    })
            },

            mouseOver(type, obj){
                var flats = document.getElementsByClassName('flat-part')
                var boxElem = event.currentTarget;

                for(let flat of flats){
                    if(flat !== boxElem){
                        flat.classList.add('flat-unhover')
                    }
                }

                var pointerElem;

                if(type==='flat'){
                    pointerElem = document.getElementById('pointer1');
                    this.boxFlatRooms = obj.rooms;
                }
                if(type==='office'){
                    pointerElem = document.getElementById('pointer_office');
                }
                if(type==='pantry'){
                    pointerElem = document.getElementById('pointer_pantry');
                }

                this.boxFlatArea = obj.area;
                this.boxFlatCoast = parseFloat(obj.coast).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ").replace('.', ',')
                this.boxFlatName = obj.name;

                var mouseX = event.pageX;
                var mouseY = event.pageY;

                if (pointerElem.classList.contains('box-pointer-hidden')) {
                    pointerElem.classList.remove('box-pointer-hidden');
                }

                pointerElem.style.transform = 'translate3d(' + mouseX + 'px, ' + mouseY + 'px, 0px)';
            },
            mouseLeave(type){
                var pointerElem;

                if(type==='flat'){
                    pointerElem = document.getElementById('pointer1');
                }
                if(type==='office'){
                    pointerElem = document.getElementById('pointer_office');
                }
                if(type==='pantry'){
                    pointerElem = document.getElementById('pointer_pantry');
                }

                pointerElem.classList.add('box-pointer-hidden');

                var flats = document.getElementsByClassName('flat-part')

                for(let flat of flats){
                    flat.classList.remove('flat-unhover')
                }
            },

            showModal(type, id, name){
                this.objectToReserve = type;
                this.objectToReserveId = id;
                this.objectToReserveName = name;

                var modal = document.querySelector('.modal-reserve')
                modal.classList.toggle('show')
            },

            hooperSlide(){
                this.$refs.hpr.slideTo(Number(this.$route.params.name))

            }
        },
        created() {
            this.fetch()

        },
        mounted() {
            // this.$refs.hpr.slideTo(15)

            // this.$refs.hooper.slideTo(15)
            this.hooperSlide()
            // this.$refs.hpr.slideTo(23)

        }
    }
</script>

<style scoped>


</style>
