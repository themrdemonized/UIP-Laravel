<template>
    <div style="position: relative">

        <div class="box-choose-house" >
            <div class="box-map-home">

<!--                <div id="c" class="box-map-rel" >-->
<!--                    <div class="govno">-->
<!--                        <div id="h" class="drag-block">-->
<!--                            <svg class="svg-maket" viewBox="0 0 2520 1080">-->
<!--                                <g v-for="object in objects" :key="object.id" :class="object.id === 1 || object.id === 2 ? 'active-part' : 'part'" @mousemove="mouseOver(object)" @mouseleave="mouseLeave()">-->
<!--                                    <path v-if="object.id === 1 || object.id === 2" :d="object.coordinates" @click="toObject(object.id)"/>-->
<!--                                    <path v-else :d="object.coordinates"/>-->
<!--                                </g>-->
<!--                            </svg>-->

<!--                            <img style="width: 100vw;" src="/img/Map_2520x1080px.jpg" alt="">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                    <div class="box-map-rel" >
                        <div class="govno">
                            <div class="drag-block">
                                <svg class="svg-maket" viewBox="0 0 2520 1080">
                                    <g
                                        v-for="object in objects"
                                        :key="object.id"
                                        :class="object.id === 1 || object.id === 2 || object.img !== null ? 'active-part' : 'part'"
                                        @mousemove="mouseOver(object)"
                                        @mouseleave="mouseLeave()"
                                    >
                                        <path v-if="object.id === 1 || object.id === 2" :d="object.coordinates" @click="toObject(object.id)"/>
                                        <path v-else-if="object.id !== 1 && object.id !== 2 && object.img !== null" :d="object.coordinates" @click="toReserve(object.id)"/>
                                        <path v-else :d="object.coordinates"/>
                                    </g>
                                </svg>
                                <img style="width: 100%;" src="/img/Map_2520x1080px.jpg" alt="">
                            </div>
                        </div>
                        <img src="/img/Map_2520x1080px.jpg" alt="">
                    </div>

                    <div id="pointer1" class="box-pointer box-pointer-hidden home">
                        <div class="box-pointer-head-title">
                            {{boxName}}
                        </div>

                        <div class="box-pointer-body">
                            <div>
                                {{boxDescr}}
                            </div>
                        </div>

                        <div class="box-pointer-bottom">
                            <div v-if="boxFlats === 0 && boxFlats !== null">
                                Свободных квартир: <span>нет</span>
                            </div>
                            <div v-if="boxFlats > 0 && boxFlats !== null">
                                Свободных квартир: <span>{{boxFlats}}</span>
                            </div>
                            <div v-if="boxParking === 0 && boxParking !== null">
                                Свободных парковок: <span>нет</span>
                            </div>
                            <div v-if="boxParking > 0 && boxParking !== null">
                                Свободных парковок: <span>{{boxParking}}</span>
                            </div>
                            <div v-if="boxPantry === 0 && boxPantry !== null">
                                Свободных кладовок: <span>нет</span>
                            </div>
                            <div v-if="boxPantry > 0 && boxPantry !== null">
                                Свободных кладовок: <span>{{boxPantry}}</span>
                            </div>
                        </div>
                    </div>
            </div>

            <form-flat-list></form-flat-list>

<!--            <div class="map-choose-opacity">-->
<!--                <div class="map-choose-opacity-map" @click="hideBoxClick">-->
<!--                    <div class="map-choose-opacity-map-block-info" >-->
<!--                        <div>-->
<!--                            <div class="map-choose-opacity-map-block-info-icon">-->
<!--                                <v-icon size="46" class="theme&#45;&#45;dark">mdi-hand-left</v-icon>-->
<!--                            </div>-->
<!--                            <div class="map-choose-opacity-map-block-info-dscr">-->
<!--                                Зажмите и потяните карту <br>-->
<!--                                для выбора объекта-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

        </div>

        <div class="box-news">
            <div class="row-news">
                <div class="col-news" v-for="(nw, index) in news" v-if="index < 3">
                    <div class="col-new" @click="showNew(nw)">
                        <div class="col-new-img">
                            <img :src="'/' + nw.photo.path" alt="" style="height: 100%; object-fit: cover; width: 100%" >
                        </div>
                        <div class="col-new-body">
                            <div class="col-new-name">
                                {{nw.title}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-icons">
            <div class="row-title">
                <div class="col-left">
                    Преимущества
                </div>
                <div class="col-right">
                    Все новости
                </div>
            </div>
            <div class="row-icons">
                <div v-for="icon in icons" class="col-icons">
                    <div class="col-icon">
                        <div class="col-icon-id">
                            {{icon.id}}
                        </div>
                        <div class="col-icon-img">
                            <img :src="icon.img" alt="" style="height: 100%">
                        </div>
                        <div class="col-icon-dscr" v-html="icon.description"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-info">
            <div class="row-info">
                <div class="col-info">
                    <div class="col-info-dscr">
                        <div class="col-info-dscr-title">
                            «Управление инвестиционных программ»
                        </div>
                        <div class="col-info-dscr-text">
                            <p>
                                «Управление инвестиционных программ» успешно ведёт свою деятельность на протяжении уже
                                многих лет.
                            </p>
                            <p>
                                Уже построено 20 жилых домов в различных районах Хабаровска.
                                В настоящее время на разной стадии строительства находятся несколько домов.
                            </p>
                            <p>
                                Мы стремимся повышать качество строительства объектов, при этом сохраняя доступный
                                уровень цен на жилые и коммерческие помещения.
                            </p>
                            <p>
                                Значительный опыт, безукоризненное соблюдение сроков строительства и положительные
                                отзывы клиентов — наши главные ценности.
                            </p>
                            <p>
                                Именно поэтому, выбирая застройщика в Хабаровске, мы рекомендуем обратить внимание на
                                нашу компанию.
                            </p>
                        </div>
                    </div>
                    <div class="col-info-img">
                        <img src="img/u181.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
    import FormFlatList from "./ChooseFlat/FormFlatList";
    import axios from 'axios'
    import {gsap} from 'gsap'
    import {Draggable} from 'gsap/Draggable'
    import Head_component from "./layout/HeadComponent";

    gsap.registerPlugin(Draggable);

    export default {
        components: {
            Head_component,
            FormFlatList
        },
        data(){
            return{
                news: [],
                objects: [],
                boxName: null,
                boxDescr: null,
                boxFlats: null,
                boxParking: null,
                boxPantry: null,
                icons: [
                    {id: 1, img: 'img/svg/house-meters.svg', description: 'Мы ввели в эксплуатацию 171 707 м<sup>2</sup> жилья'},
                    {id: 2, img: 'img/svg/house-build.svg', description: 'Нами было построено двадцать три объекта'},
                    {id: 3, img: 'img/svg/house-key.svg', description: 'В наших домах отметили новоселье 3627 семей'},
                    {id: 4, img: 'img/svg/house-like.svg', description: '99% объектов введено без задержек'},
                    {id: 5, img: 'img/svg/house-grow.svg', description: 'Построили более 20 жилых домов'},
                    {id: 6, img: 'img/svg/house-location.svg', description: 'Опыт строительства в Хабаровске более 15 лет'},
                ]
            }
        },
        methods:{
            toObject(id){
                this.$router.push({name: 'chooseHouse' , params: { id: id } })
            },
            toReserve(id){
                this.$router.push({name: 'reserve' , params: { id: id } })
            },
            // hideBoxClick(){
            //     document.querySelector('.map-choose-opacity').classList.add('hide');
            // },
            mouseOver(object){
                var pointerElem = document.getElementById('pointer1');

                this.boxName = object.name
                this.boxDescr = object.description
                this.boxFlats = object.empty_flats
                this.boxParking = object.empty_parking
                this.boxPantry = object.empty_pantry

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
            hideBoxTimer(){
                function hide() {
                    document.querySelector('.map-choose-opacity').classList.add('hide')
                }

                setTimeout(hide, 3000);
            },
            fetch(){
                axios.get('/api/news')
                    .then(response=>{
                        this.news = response.data.news
                    })
                axios.get('/api/objects')
                    .then(response=>{
                        this.objects = response.data.objects
                    })
            },
            showNew(nw){
                this.$router.push({name: 'showNew', params: {pNw: nw, id: nw.id}})
            }
        },
        created(){
            this.fetch()
        },
        mounted() {
            // this.hideBoxTimer()
            //
            // Draggable.create("#h", {
            //     type: "x,y",
            //     bounds: document.getElementById("c"),
            // })
        }
    }
</script>
