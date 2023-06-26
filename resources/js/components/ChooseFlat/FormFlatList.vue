<template>

    <div class="item-filters home-filter">

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

        <div class="item-filter" style="padding-right: .5rem;">
            <div class="item-filter__head">Жилой комплекс</div>
            <div class="item-filter__body">
                <v-select
                    :items="objects"
                    filled
                    dense
                    height="50px"
                    background-color="#ffffff"
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

        <div class="item-filter" style="padding-right: unset;">
            <div class="item-filter__body" style="height: 100%; margin-bottom: .25rem">
                <div class="item-filter__link">

                    <router-link
                        class="filter-link"
                        :to="{
                        name: 'flatList',
                        params:{
                            pRangePrice: this.rangePrice,
                            pRangeArea: this.rangeArea,
                            pSelectRoom: this.roomFilter,
                            pSelectObject: this.objectFilter
                        }
                    }"
                    >
                        <div class="filter-link__text">
                            Квартир найдено: {{flats.length}}
                        </div>
                    </router-link>

                </div>

            </div>
        </div>
    </div>

</template>

<script>
    import axios from 'axios'
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'

    export default {
        name: "FormFlatList",
        components:{
            VueSlider
        },
        data(){
            return{
                flats: [],
                objects:[
                    {id: 1, name: 'Восточный парк'},
                    {id: 2, name: 'Петроглиф парк'}
                ],
                minPrice: 1,
                maxPrice: 20000000,
                rangePrice: [],

                minArea: 10,
                maxArea: 200,
                rangeArea: [],

                roomFilter: [],
                objectFilter: [],

                loading: false,
            }
        },
        created(){
          this.fetch();
        },
        methods:{
            fetch() {
                if (this.loading === false) {
                    this.loading = true;

                    axios.get('/api/flats')
                        .then(response => {
                            this.flats = response.data.flats;
                            this.minPrice = response.data.minPrice;
                            this.maxPrice = response.data.maxPrice;
                            this.$refs.priceSlider.setValue([response.data.minPrice, response.data.maxPrice]);

                            this.minArea = Math.round(response.data.minArea) - 1;
                            this.maxArea = Math.round(response.data.maxArea) + 1;
                            this.$refs.areaSlider.setValue([Math.round(response.data.minArea) - 1, Math.round(response.data.maxArea) + 1]);

                            this.loading = false;
                        })
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
            filterRoom(event, number){
                var divRoom = event.currentTarget;

                if(!this.roomFilter.includes(number)){
                    divRoom.classList.add('active');
                    this.roomFilter.push(number);
                    this.getData();

                }
                else{
                    divRoom.classList.remove('active');
                    let index = this.roomFilter.indexOf(number);
                    this.roomFilter.splice(index, 1);
                    this.getData();
                }
            },
            find(){
                this.$router.push({name: 'flatList', params:{
                        pRangePrice: this.rangePrice,
                        pRangeArea: this.rangeArea,
                        pSelectRoom: this.roomFilter,
                        pSelectObject: this.objectFilter
                    }})
            }
        }
    }
</script>

<style scoped>

</style>
