<template>
    <div class="item-list">

        <div class="item-list__head">
            <head_component
                title="Коммерческая недвижимость"
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
                            <vue-slider style="padding: unset" :tooltip="'none'" :clickable="false" :min="minPrice" :max="maxPrice"  v-model="rangePrice" ref="priceSlider" @drag-end="filter()"></vue-slider>
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
                            <vue-slider style="padding: unset" :tooltip="'none'" :clickable="false" :min="minArea" :max="maxArea"  v-model="rangeArea" ref="areaSlider"  @drag-end="filter()"></vue-slider>
                        </div>
                    </div>
                </div>

                <div class="item-filter">
                    <div class="item-filter__head">Объект</div>
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
                            @change="filter()"
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
                    <v-icon class="sort__icon" id="price-up" x-small>mdi-arrow-up</v-icon>
                    <v-icon class="sort__icon" id="price-down" style="margin-left: -.3rem;" x-small>mdi-arrow-down</v-icon>
                </div>
                <div class="sort__area" @click="orderByArea(areaOrder)">
                    площади
                    <v-icon class="sort__icon" id="area-up" x-small>mdi-arrow-up</v-icon>
                    <v-icon class="sort__icon" id="area-down" style="margin-left: -.3rem;" x-small>mdi-arrow-down</v-icon>
                </div>
            </div>
            <div class="items-count">
                <div v-if="!loading" class="items-count__length">
                    Офисов найдено: {{offices.length}}
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

        <div class="item-list__body item-list-offices">

            <div class="item-list__items">
                <div v-for="office in offices" :key="office.id" class="item-list__item item" :class="{'loading' : loading}">

                    <div class="item__prop">
                        <div class="item__object">{{office.floorr.house.object.name}}</div>
                        <div v-if="office.floorr.house.object.type !== 'tc'" class="item__house">Дом {{office.floorr.house.name}}</div>
                    </div>

                    <div class="item__prop item__date">
                        {{office.floorr.house.description}}
                    </div>

                    <div class="item__prop">
                        <div class="item__floor">Этаж {{office.floorr.name}}</div>
                        <div class="item__flat">Номер {{office.name}}</div>
                    </div>

                    <div class="item__prop item__area">{{office.area}} м<sup>2</sup></div>

                    <div class="item__prop item__price">{{office.coast}} руб.</div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import axios from 'axios'
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'
    import Head_component from "./layout/HeadComponent";

    export default {
        name: "Commercial",
        components:{
            Head_component,
            VueSlider
        },
        data(){
            return{
                offices: [],
                loading: false,
                areaOrder: null,
                priceOrder: null,

                minPrice: 1,
                maxPrice: 130000000,
                rangePrice: [],

                minArea: 20,
                maxArea: 250,
                rangeArea: [],

                objects: [],
                objectFilter: null,
            }
        },
        methods:{
            fetch(){
                if(this.loading === false){
                    this.loading = true;

                    this.$http.get('/api/offices')
                        .then(response=>{
                            this.offices = response.data.offices
                            this.objects = response.data.objects

                            this.minPrice = response.data.minPrice;
                            this.maxPrice = response.data.maxPrice;
                            this.$refs.priceSlider.setValue([response.data.minPrice,response.data.maxPrice]);

                            this.minArea = Math.round(response.data.minArea)-1;
                            this.maxArea = Math.round(response.data.maxArea)+1;
                            this.$refs.areaSlider.setValue([Math.round(response.data.minArea)-1,Math.round(response.data.maxArea)+1]);

                            this.loading = false;
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
                        this.filter();
                        break;
                    case 'asc':
                        this.priceOrder = 'desc';
                        up = up.classList.remove('arrow-active');
                        down = down.classList.add('arrow-active');
                        this.filter();
                        break;
                    case 'desc':
                        this.priceOrder = null;
                        up = up.classList.remove('arrow-active');
                        down = down.classList.remove('arrow-active');
                        this.filter();
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
                        this.filter();
                        break;
                    case 'asc':
                        this.areaOrder = 'desc';
                        up = up.classList.remove('arrow-active');
                        down = down.classList.add('arrow-active');
                        this.filter();
                        break;
                    case 'desc':
                        this.areaOrder = null;
                        up = up.classList.remove('arrow-active');
                        down = down.classList.remove('arrow-active');
                        this.filter();
                        break;
                    default:
                        break
                }
            },
            filter(){
                if(this.loading === false){

                    this.loading = true;

                    axios.get('/api/offices',{
                        params: {
                            price: this.priceOrder,
                            area: this.areaOrder,
                            rangePrice: this.rangePrice,
                            rangeArea: this.rangeArea,
                            objectFilter: this.objectFilter,
                        }
                    }).then(response=>{
                        this.offices = response.data.offices;
                        this.loading = false;
                    })
                }
            },
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
            this.fetch()
        }
    }
</script>

<style scoped>

</style>
