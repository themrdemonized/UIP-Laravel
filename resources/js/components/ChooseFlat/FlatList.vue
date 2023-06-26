<template>

    <div class="item-list">

        <div class="item-list__head">
            <head_component
                title="Квартиры в новостройке"
            ></head_component>

            <div class="item-list__filter item-filters">

                <div class="item-filter">
                    <div class="item-filter__head">Стоимость, руб.</div>

                    <div class="item-filter__body">

                        <div class="item-filter__values">
                            <div class="item-filter__span">
                                <span class="item-filter__from">от</span>
                                <span>{{Intl.NumberFormat('ru-RU').format(rangePrice[0])}}</span>
                            </div>
                            <div class="item-filter__span">
                                <span class="item-filter__to">до</span>
                                <span>{{Intl.NumberFormat('ru-RU').format(rangePrice[1])}}</span>
                            </div>
                        </div>

                        <div class="item-filter__slider">
                            <vue-slider style="padding: unset" :tooltip="'none'" :clickable="false" :min="minPrice" :max="maxPrice"  v-model="rangePrice" ref="priceSlider" @drag-end="getData()"></vue-slider>
                        </div>

                    </div>

                    </div>

                <div class="item-filter">
                    <div class="item-filter__head">Площадь, м<sup>2</sup></div>
                    <div class="item-filter__body">

                        <div class="item-filter__values">
                            <div class="item-filter__span">
                                <span class="item-filter__from">от</span>
                                <span>{{rangeArea[0]}}</span>
                            </div>
                            <div class="item-filter__span">
                                <span class="item-filter__to">до</span>
                                <span>{{rangeArea[1]}}</span>
                            </div>
                        </div>

                        <div class="item-filter__slider">
                            <vue-slider style="padding: unset" :tooltip="'none'" :clickable="false" :min="minArea" :max="maxArea"  v-model="rangeArea" ref="areaSlider"  @drag-end="getData()"></vue-slider>
                        </div>
                    </div>
                </div>

                <div class="item-filter">
                    <div class="item-filter__head">Комнатность</div>
                    <div class="item-filter__body">
                        <div class="item-filter__rooms filter-rooms">
                            <div data-id="0" class="filter-rooms__num" @click="filterRoom($event, 0)">
                                <span>С</span>
                            </div>
                            <div data-id="1" class="filter-rooms__num" @click="filterRoom($event, 1)">
                                <span>1</span>
                            </div>
                            <div data-id="2" class="filter-rooms__num" @click="filterRoom($event, 2)">
                                <span>2</span>
                            </div>
                            <div data-id="3" class="filter-rooms__num" @click="filterRoom($event, 3)">
                                <span>3</span>
                            </div>
                            <div data-id="4" class="filter-rooms__num" @click="filterRoom($event, 4)">
                                <span>4+</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-filter">
                    <div class="item-filter__head">Жилой комплекс</div>
                    <div class="item-filter__body">
                        <v-select
                            :items="objects"
                            filled
                            dense
                            height="50px"
                            background-color="#f5f5f5"
                            item-text="name"
                            item-value="id"
                            multiple
                            v-model="objectFilter"
                            @change="getData()"
                            placeholder="Выберите из списка"
                            item-color="#3e4577"
                        ></v-select>
                    </div>
                </div>

            </div>
        </div>

        <div class="item-list__count">
            <div class="item-list__sort sort">
                По
                <div class="sort__price"  @click="orderByPrice(priceOrder)">
                    цене
                    <v-icon id="price-up" x-small>mdi-arrow-up</v-icon>
                    <v-icon id="price-down" style="margin-left: -.3rem;" x-small>mdi-arrow-down</v-icon>
                </div>
                <div class="sort__area" @click="orderByArea(areaOrder)">
                    площади
                    <v-icon id="area-up" x-small>mdi-arrow-up</v-icon>
                    <v-icon id="area-down" style="margin-left: -.3rem;" x-small>mdi-arrow-down</v-icon>
                </div>
            </div>
            <div class="items-count">
                <div v-if="!loading" class="items-count__length">
                    Квартир найдено: {{flats.length}}
                </div>
                <div v-else>
                    <v-progress-circular
                        indeterminate
                        color="#555555"
                        size="20"
                    ></v-progress-circular>
                </div>
            </div>

        </div>

        <div class="item-list__body">

            <div class="item-list__items ">
                <router-link :to="{name: 'flat', params: {id:flat.id} }" v-for="flat in flats" :key="flat.id" class="item-list__item item" :class="{'loading' : loading}">

                    <div class="item__prop">
                        <div class="item__object">{{flat.floorr.house.object.name}}</div>
                        <div class="item__house">Дом {{flat.floorr.house.name}}</div>
                    </div>

                    <div class="item__prop item__date">
                        {{flat.floorr.house.description}}
                    </div>

                    <div class="item__prop">
                        <div class="item__floor">Этаж {{flat.floorr.name}}</div>
                        <div class="item__flat">Номер {{flat.name}}</div>
                    </div>

                    <div class="item__prop item__rooms" v-if="flat.rooms === 1">{{flat.rooms}} комната</div>
                    <div class="item__prop item__rooms" v-if="flat.rooms > 1 && flat.rooms < 5">{{flat.rooms}} комнаты</div>
                    <div class="item__prop item__rooms" v-if="flat.rooms >= 5">{{flat.rooms}} комнат</div>

                    <div class="item__prop item__area">{{flat.area}} м<sup>2</sup></div>

                    <div class="item__prop item__price">{{flat.coast}} руб.</div>
                </router-link>
            </div>
        </div>

    </div>

<!--    <div>-->
<!--        <div class="filter-head">-->

<!--            <Head_component-->
<!--                title="Квартиры в новостройке"-->
<!--            ></Head_component>-->

<!--            <div class="filter-props">-->
<!--                <div class="filter-col">-->
<!--                    <div class="filter-col-body">-->
<!--                        <div class="filter">-->
<!--                            <div class="filter-span">-->
<!--                                <span>{{Intl.NumberFormat('ru-RU').format(rangePrice[0])}}</span>-->
<!--                            </div>-->
<!--                            <div class="filter-span">-->
<!--                                <span>Стоимость</span>-->
<!--                            </div>-->
<!--                            <div class="filter-span">-->
<!--                                <span>{{Intl.NumberFormat('ru-RU').format(rangePrice[1])}}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <vue-slider :tooltip="'none'" :clickable="false" :min="minPrice" :max="maxPrice"  v-model="rangePrice" ref="priceSlider" @drag-end="getData()"></vue-slider>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="filter-col">-->
<!--                    <div class="filter-col-body">-->
<!--                        <div class="filter">-->
<!--                            <div class="filter-span">-->
<!--                                <span>{{rangeArea[0]}}</span>-->
<!--                            </div>-->
<!--                            <div class="filter-span">-->
<!--                                <span>Площадь</span>-->
<!--                            </div>-->
<!--                            <div class="filter-span">-->
<!--                                <span>{{rangeArea[1]}}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <vue-slider :tooltip="'none'" :clickable="false" :min="minArea" :max="maxArea"  v-model="rangeArea" ref="areaSlider"  @drag-end="getData()"></vue-slider>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="filter-col">-->
<!--                    <div class="filter-col-body">-->
<!--                        <div class="filter-rooms">-->
<!--                            <div class="filter-rooms-span">-->
<!--                                <div data-id="0" class="filter-rooms-span-border" @click="filterRoom($event, 0)">-->
<!--                                    <span>С</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div  class="filter-rooms-span">-->
<!--                                <div data-id="1" class="filter-rooms-span-border" @click="filterRoom($event, 1)">-->
<!--                                    <span>1</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="filter-rooms-span">-->
<!--                                <div data-id="2" class="filter-rooms-span-border" @click="filterRoom($event, 2)">-->
<!--                                    <span>2</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div  class="filter-rooms-span">-->
<!--                                <div data-id="3" class="filter-rooms-span-border" @click="filterRoom($event, 3)">-->
<!--                                    <span>3</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="filter-rooms-span">-->
<!--                                <div data-id="4" class="filter-rooms-span-border" @click="filterRoom($event, 4)">-->
<!--                                    <span>4+</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="filter-col">-->
<!--                    <div class="filter-col-body" style="width: 100%">-->
<!--                        <v-select-->
<!--                            :items="objects"-->
<!--                            item-text="name"-->
<!--                            item-value="id"-->
<!--                            v-model="objectFilter"-->
<!--                            label="Жилой комплекс"-->
<!--                            @change="getData()"-->
<!--                        ></v-select>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--&lt;!&ndash;            <div class="filter-more">&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="filter-more-show-btn">&ndash;&gt;-->
<!--&lt;!&ndash;                    +&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;            </div>&ndash;&gt;-->

<!--        </div>-->

<!--        <div class="search-flats">-->
<!--            <div v-if="!loading" class="search-flats-number">-->
<!--                Найдено {{flats.length}} квартир-->
<!--            </div>-->
<!--            <div v-else>-->
<!--                <v-progress-circular-->
<!--                    indeterminate-->
<!--                    color="#555555"-->
<!--                ></v-progress-circular>-->
<!--            </div>-->
<!--        </div>-->

<!--        <div class="flats-list">-->
<!--            <div class="flats-list-box">-->
<!--                <div class="flat-list-sort">-->
<!--                    <div class="flat-list-sort-by">-->
<!--                        Объект-->
<!--                    </div>-->
<!--                    <div class="flat-list-sort-by">-->
<!--                        Дом-->
<!--                    </div>-->
<!--                    <div class="flat-list-sort-by">-->
<!--                        Этаж-->
<!--                    </div>-->
<!--                    <div class="flat-list-sort-by active" @click="orderByArea(areaOrder)">-->
<!--                        Площадь-->
<!--                        <v-icon id="area-up" x-small>mdi-arrow-up</v-icon>-->
<!--                        <v-icon id="area-down" x-small>mdi-arrow-down</v-icon>-->
<!--                    </div>-->
<!--                    <div class="flat-list-sort-by active" @click="orderByRoom(roomOrder)">-->
<!--                        Комнат-->
<!--                        <v-icon id="room-up" x-small>mdi-arrow-up</v-icon>-->
<!--                        <v-icon id="room-down" x-small>mdi-arrow-down</v-icon>-->
<!--                    </div>-->
<!--                    <div class="flat-list-sort-by active" @click="orderByPrice(priceOrder)">-->
<!--                        Цена-->
<!--                        <v-icon id="price-up" x-small>mdi-arrow-up</v-icon>-->
<!--                        <v-icon id="price-down" x-small>mdi-arrow-down</v-icon>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="flat-list">-->
<!--                    <router-link class="flat-list-flat" :class="{'loading' : loading}"  v-for="flat in flats" :key="flat.id" :to="{name: 'flat', params:{id: flat.id}}">-->
<!--&lt;!&ndash;                    <div class="flat-list-flat" v-for="flat in flats" @click="$router.push({name: 'flat', params:{id: flat.id}})" v-if="flat.status_id = 1">&ndash;&gt;-->
<!--                        <div class="flat-list-flat-param">-->
<!--                            {{flat.floorr.house.object.name}}-->
<!--                        </div>-->
<!--&lt;!&ndash;                        <div v-if="flat.floorr.house.status_id === 3" class="flat-list-flat-param">&ndash;&gt;-->
<!--&lt;!&ndash;                            Планируется&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                        <div v-if="flat.floorr.house.status_id === 2" class="flat-list-flat-param">&ndash;&gt;-->
<!--&lt;!&ndash;                            Строится&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                        <div v-if="flat.floorr.house.status_id === 1" class="flat-list-flat-param">&ndash;&gt;-->
<!--&lt;!&ndash;                            Построен&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--                        <div class="flat-list-flat-param">-->
<!--                            {{flat.floorr.house.name}}-->
<!--                        </div>-->
<!--                        <div class="flat-list-flat-param">-->
<!--                            {{flat.floorr.name}}-->
<!--                        </div>-->
<!--                        <div class="flat-list-flat-param">-->
<!--                            {{flat.area}} м<sup>2</sup>-->
<!--                        </div>-->
<!--                        <div class="flat-list-flat-param">-->
<!--                            {{flat.rooms}}-->
<!--                        </div>-->
<!--                        <div class="flat-list-flat-param">-->
<!--                            {{Intl.NumberFormat('ru-RU').format(flat.coast)}} ₽-->
<!--                        </div>-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--                    </router-link>-->
<!--                </div>-->
<!--            </div>-->

<!--        </div>-->

<!--    </div>-->


</template>

<script>
    import axios from 'axios'
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'
    import Head_component from "../layout/HeadComponent";

    export default {
        name: "FlatList",
        components:{
            Head_component,
            VueSlider
        },
        props:{
            pRangePrice: {
                type: Array,
                default: function () {
                    return null
                }
            },
            pRangeArea: {
                type: Array,
                default: function () {
                    return null
                }
            },
            pSelectRoom: {
                type: Array,
                default: function () {
                    return null
                }
            },
            pSelectObject: {
                type: Array,
                default: function () {
                    return null
                }
            },
            pSelectHouse: {
                type: Number,
                default: null
            },
            pSelectFloor: {
                type: Number,
                default: null
            }
        },
        data(){
            return{
                flats: [],
                numOfFlats: null,
                objectOrder: null,
                statusOrder: null,
                floorOrder: null,
                roomOrder: null,
                areaOrder: null,
                priceOrder: null,

                clickable: false,

                minPrice: 1,
                maxPrice: 130000000,
                rangePrice: [],

                minArea: 20,
                maxArea: 100,
                rangeArea: [],

                minFloor: 1,
                maxFloor: 25,
                rangeFloor: [],

                roomFilter: [],

                loading: false,

                objects: [
                    {id: 1, name: 'Восточный парк'},
                    {id: 2, name: 'Петроглиф парк'},
                ],
                objectFilter: null,
                houseFilter: null,
                floorFilter: null,
            }
        },
        methods:{
            showModal(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            },
            filterRoom(event, number){
                if(this.loading === false){
                    var divRoom = event.currentTarget;

                    if(!this.roomFilter.includes(number)){
                        divRoom.classList.add('active');
                        this.roomFilter.push(number);
                        console.log(this.roomFilter);
                        this.getData();
                    }
                    else{
                        divRoom.classList.remove('active');
                        let index = this.roomFilter.indexOf(number);
                        this.roomFilter.splice(index, 1);
                        console.log(this.roomFilter);
                        this.getData();
                    }
                }
            },
            getData(){
                if(this.loading === false){

                    this.loading = true;

                    axios.get('/api/flats',{
                        params: {
                            price: this.priceOrder,
                            room: this.roomOrder,
                            area: this.areaOrder,
                            object: this.objectOrder,
                            status: this.statusOrder,
                            floor: this.floorOrder,
                            rangePrice: this.rangePrice,
                            rangeArea: this.rangeArea,
                            rangeFloor: this.rangeFloor,
                            roomFilter: this.roomFilter,
                            objectFilter: this.objectFilter,
                        }
                    }).then(response=>{
                        this.flats = response.data.flats;
                        this.loading = false;
                    })
                }
            },
            fetch(){
                if(this.loading === false){
                    this.loading = true;

                    axios.get('/api/flats', {
                        params:{
                            roomFilter: this.pSelectRoom,
                            rangePrice: this.pRangePrice,
                            rangeArea: this.pRangeArea,
                            objectFilter: this.pSelectObject,
                            houseFilter: this.pSelectHouse,
                            floorFilter: this.pSelectFloor
                        }
                    })
                        .then(response=>{
                            this.flats = response.data.flats;
                            this.minPrice = response.data.minPrice;
                            this.maxPrice = response.data.maxPrice;
                            if(this.pRangePrice !== null){
                                this.$refs.priceSlider.setValue([this.pRangePrice[0],this.pRangePrice[1]]);
                            }
                            else{
                                this.$refs.priceSlider.setValue([response.data.minPrice,response.data.maxPrice]);
                            }

                            this.minArea = Math.round(response.data.minArea)-1;
                            this.maxArea = Math.round(response.data.maxArea)+1;
                            if(this.pRangeArea !== null){
                                this.$refs.areaSlider.setValue([Math.round(this.pRangeArea[0]),Math.round(this.pRangeArea[1])]);
                            }
                            else{
                                this.$refs.areaSlider.setValue([Math.round(response.data.minArea)-1,Math.round(response.data.maxArea)+1]);
                            }
                            //
                            // this.minFloor = response.data.minFloor;
                            // this.maxFloor = response.data.maxFloor;
                            // this.$refs.floorSlider.setValue([response.data.minFloor,response.data.maxFloor]);

                            this.loading = false;
                            // if (localStorage.rangePriceMin && localStorage.rangePriceMax) {
                            //     this.$refs.priceSlider.setValue([Number(localStorage.rangePriceMin),Number(localStorage.rangePriceMax)]);
                            // }
                            // else{
                            //     this.$refs.priceSlider.setValue([response.data.min,response.data.max]);
                            // }
                        })
                }
            },
            orderByPrice(price){
                this.removeActiveArrows();
                var up = document.getElementById('price-up');
                var down = document.getElementById('price-down');

                switch (price) {
                    case null:
                        this.priceOrder = 'asc';
                        up = up.classList.add('arrow-active');
                        this.getData();
                        break;
                    case 'asc':
                        this.priceOrder = 'desc';
                        up = up.classList.remove('arrow-active');
                        down = down.classList.add('arrow-active');
                        this.getData();
                        break;
                    case 'desc':
                        this.priceOrder = null;
                        up = up.classList.remove('arrow-active');
                        down = down.classList.remove('arrow-active');
                        this.getData();
                        break;
                    default:
                        break;
                }
            },
            orderByRoom(room){
                this.removeActiveArrows();
                var up = document.getElementById('room-up');
                var down = document.getElementById('room-down');

                switch (room) {
                    case null:
                        this.roomOrder = 'asc';
                        up = up.classList.add('arrow-active');
                        this.getData();
                        break;
                    case 'asc':
                        this.roomOrder = 'desc';
                        up = up.classList.remove('arrow-active');
                        down = down.classList.add('arrow-active');
                        this.getData();
                        break;
                    case 'desc':
                        this.roomOrder = null;
                        up = up.classList.remove('arrow-active');
                        down = down.classList.remove('arrow-active');
                        this.getData();
                        break;
                    default:
                        break;
                }
            },
            orderByArea(area){
                this.removeActiveArrows();
                var up = document.getElementById('area-up');
                var down = document.getElementById('area-down');

                switch (area) {
                    case null:
                        this.areaOrder = 'asc';
                        up = up.classList.add('arrow-active');
                        this.getData();
                        break;
                    case 'asc':
                        this.areaOrder = 'desc';
                        up = up.classList.remove('arrow-active');
                        down = down.classList.add('arrow-active');
                        this.getData();
                        break;
                    case 'desc':
                        this.areaOrder = null;
                        up = up.classList.remove('arrow-active');
                        down = down.classList.remove('arrow-active');
                        this.getData();
                        break;
                    default:
                        break
                }
            },


            // orderByObject(object){
            //     this.removeActiveArrows()
            //     var up = document.getElementById('object-up');
            //     var down = document.getElementById('object-down');
            //
            //     switch (object) {
            //         case null:
            //             this.objectOrder = 'asc';
            //             up = up.classList.add('arrow-active');
            //             this.getData();
            //             break;
            //         case 'asc':
            //             this.objectOrder = 'desc';
            //             up = up.classList.remove('arrow-active');
            //             down = down.classList.add('arrow-active');
            //             this.getData();
            //             break;
            //         case 'desc':
            //             this.objectOrder = null;
            //             up = up.classList.remove('arrow-active');
            //             down = down.classList.remove('arrow-active');
            //             this.getData();
            //             break;
            //         default:
            //             break
            //     }
            // },
            // orderByStatus(status){
            //     this.removeActiveArrows()
            //     var up = document.getElementById('status-up');
            //     var down = document.getElementById('status-down');
            //
            //     switch (status) {
            //         case null:
            //             this.statusOrder = 'asc';
            //             up = up.classList.add('arrow-active');
            //             this.getData();
            //             break;
            //         case 'asc':
            //             this.statusOrder = 'desc';
            //             up = up.classList.remove('arrow-active');
            //             down = down.classList.add('arrow-active');
            //             this.getData();
            //             break;
            //         case 'desc':
            //             this.statusOrder = null;
            //             up = up.classList.remove('arrow-active');
            //             down = down.classList.remove('arrow-active');
            //             this.getData();
            //             break;
            //         default:
            //             break
            //     }
            // },
            // orderByFloor(floor){
            //     this.removeActiveArrows()
            //     var up = document.getElementById('floor-up');
            //     var down = document.getElementById('floor-down');
            //
            //     switch (floor) {
            //         case null:
            //             this.floorOrder = 'asc';
            //             up = up.classList.add('arrow-active');
            //             this.getData();
            //             break;
            //         case 'asc':
            //             this.floorOrder = 'desc';
            //             up = up.classList.remove('arrow-active');
            //             down = down.classList.add('arrow-active');
            //             this.getData();
            //             break;
            //         case 'desc':
            //             this.floorOrder = null;
            //             up = up.classList.remove('arrow-active');
            //             down = down.classList.remove('arrow-active');
            //             this.getData();
            //             break;
            //         default:
            //             break
            //     }
            // },
            //


            removeActiveArrows(){
                this.priceOrder = null;
                this.roomOrder = null;
                this.areaOrder = null;
                this.objectOrder = null;
                this.floorOrder = null;
                this.statusOrder = null;
                var arrowsUp = document.querySelectorAll('.mdi-arrow-up');
                var arrowsDown = document.querySelectorAll('.mdi-arrow-down');
                for(let arrow of arrowsUp){
                    arrow.classList.remove('arrow-active')
                }
                for(let arrow of arrowsDown){
                    arrow.classList.remove('arrow-active')
                }
            }
        },

        created() {
            this.fetch();
        },

        mounted() {
            if(this.pSelectRoom !== null){
                var rooms = document.getElementsByClassName('filter-rooms__num')

                for(let room of rooms){
                    if(this.pSelectRoom.includes(Number(room.getAttribute('data-id')))){
                        room.classList.add('active')
                        this.roomFilter.push(Number(room.getAttribute('data-id')))
                    }
                    // console.log(this.pSelectRoom.includes(Number(room.getAttribute('data-id'))))
                }
            }
            if(this.pSelectObject !== null) {
                this.objectFilter = this.pSelectObject
            }
        }
    }
</script>

<style scoped>

</style>
