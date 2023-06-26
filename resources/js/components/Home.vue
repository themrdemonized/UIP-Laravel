<template>
    <div class="home" style="position: relative">
<!--        <head_component-->
<!--            :is-contrast="true"-->
<!--            :is-home="true"-->
<!--        ></head_component>-->



        <div class="city-plan">

            <v-carousel height="550" hide-delimiters>
                <v-carousel-item>
                    <svg class="svg-maket" viewBox="0 0 2520 1080">
                        <g
                            v-for="object in objects"
                            :key="object.id"
                            :class="object.id === 1 || object.id === 2 || object.img !== null ? 'active-part' : 'part'"
                            @mousemove="mouseOver(object)"
                            @mouseleave="mouseLeave()"
                        >
                            <path v-if="object.id === 1 || object.id === 2 || object.id === 10" :d="object.coordinates" @click="toObject(object.id)"/>
                            <path v-else-if="object.id === 16" :d="object.coordinates" @click="toHouse(object.houses[0].id)"/>
                            <path v-else-if="object.id !== 1 && object.id !== 2 && object.id !== 16 && object.img !== null" :d="object.coordinates" @click="toReserve(object.id)"/>
                            <path v-else :d="object.coordinates"/>
                        </g>
                    </svg>
                    <img style="width: 100%;" src="/img/Map_2520x1080px.jpg" alt="">

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
                </v-carousel-item>
                <v-carousel-item>
                    Аукцион петроглиф парк 4
                </v-carousel-item>
            </v-carousel>




        </div>
        <div class="filter-form home__filter">
            <div class="content">
                <form-flat-list></form-flat-list>
            </div>
        </div>
        <div class="current-projects home__current-projects">
            <div class="content">
                <div class="current-projects__head">
                    <div class="home-title current-projects__title">
                        Текущие прокекты
                    </div>
                </div>
                <div class="current-projects__body">

                    <router-link
                        class="current-projects__link"
                        v-for="object in objects"
                        v-if="object.id === 1 || object.id === 2"
                        :to="{name: 'chooseHouse', params: {id: object.id}}"
                        :key="object.coordinates"
                    >
                        <div class="current-project current-projects__project">
                            <div class="current-project__img-block">
                                <img class="current-project__img" :src="object.img" :alt="object.name">
                            </div>
                            <div class="current-project__info">
                                <div class="current-project__name">
                                    {{object.name}}
                                </div>
                                <div class="current-project__flats-info">
                                    <div class="current-project__num">
                                        {{empty(object.emptyFlats)}}
                                    </div>
                                    <div class="current-project__min">
                                        {{minPrice(object.minPrice)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="news home__news">
            <div class="content">
                <div class="news__head">
                    <div class="home-title news__title">
                        Новости
                    </div>
                    <div class="news__all">
                        <router-link class="home-link news__link" :to="{name: 'news'}">Все новости</router-link>
                    </div>
                </div>
                <news-component></news-component>
            </div>
        </div>
        <div class="about">
            <div class="content-fluid">
                <div class="about__body">
                    <div class="content about__background">
                        <div class="home-title about__title">
                            О компании
                        </div>
                        <div class="about__description">
                            <p>
                                «Управление инвестиционных программ» успешно ведёт свою деятельность на протяжении
                                многих лет. Уже построено 20 жилых домов в различных районах Хабаровска.
                                В настоящее время на разной стадии строительства находятся несколько домов.
                                Мы стремимся повышать качество строительства объектов, при этом сохраняя доступный
                                уровень цен на жилые и коммерческие помещения. Значительный опыт, безукоризненное соблюдение сроков строительства и положительные
                                отзывы клиентов — наши главные ценности. Именно поэтому, выбирая застройщика в Хабаровске, мы рекомендуем обратить внимание на
                                нашу компанию.
                            </p>
                        </div>
                        <div class="about__more">
                            <router-link class="btn-about about__link" :to="{name: 'about'}">
                                    Подробнее о компании
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="advantages">
            <div class="content">
                <div class="advantages__head">
                    <div class="home-title advantages__title">
                        Достижения
                    </div>
                </div>
                <div class="advantages__body">
                    <div class="advantages-list">
                        <div v-for="advantage in advantages" class="advantage-card">
                            <div class="advantage-card__id">
                               {{advantage.id}}
                            </div>
                            <div class="advantage-card__icon">
                                <img :src="advantage.img" alt="" style="height: 100%">
                            </div>
                            <div v-html="advantage.description" class="advantage-card__description"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer-component></footer-component>
    </div>
</template>

<script>
    import FormFlatList from "./ChooseFlat/FormFlatList";
    import Head_component from "./layout/HeadComponent";
    import News from "./News";
    import NewsComponent from "./layout/NewsComponent";
    import FooterComponent from "./layout/FooterComponent";
    export default {
        name: "Home",
        components: {FooterComponent, NewsComponent, Head_component, FormFlatList},
        data(){
            return{
                objects: [],
                currentObjects: [],
                advantages: [
                    {id: 1, img: 'img/svg/house-meters.svg', description: 'Мы ввели в эксплуатацию 171 707 м<sup>2</sup> жилья'},
                    {id: 2, img: 'img/svg/house-build.svg', description: 'Нами было построено двадцать три объекта'},
                    {id: 3, img: 'img/svg/house-key.svg', description: 'В наших домах отметили новоселье 3627 семей'},
                    {id: 4, img: 'img/svg/house-like.svg', description: '99% объектов введено без задержек'},
                    {id: 5, img: 'img/svg/house-grow.svg', description: 'Построили более 20 жилых домов'},
                    {id: 6, img: 'img/svg/house-location.svg', description: 'Опыт строительства в Хабаровске более 15 лет'},
                ],
                boxName: null,
                boxDescr: null,
                boxFlats: null,
                boxParking: null,
                boxPantry: null,
            }
        },
        methods:{
            empty(num, str2 = 'квартир'){
                var str = String(num).slice(-1);

                if (String(num).length === 1){
                    if(Number(str) === 1){
                        str2 =  'квартра';
                    }
                    else if(Number(str) > 1 && Number(str) < 5 ){
                        str2 =  'квартры';
                    }
                }

                if (String(num).length === 2 && num > 19 && num < 100){
                    if(Number(str) === 1){
                        str2 =  'квартира';
                    }
                    else if(Number(str) > 1 && Number(str) < 5 ){
                        str2 =  'квартиры';
                    }
                }

                if (String(num).length === 3 && num > 100 && num < 105){
                    if(Number(str) === 1){
                        str2 =  'квартира';
                    }
                    else if(Number(str) > 1 && Number(str) < 5){
                        str2 =  'квартиры';
                    }
                }

                if (String(num).length === 3 && num > 119 && num < 1000){
                    if(Number(str) === 1){
                        str2 =  'квартира';
                    }
                    else if(Number(str) > 1 && Number(str) < 5){
                        str2 =  'квартиры';
                    }
                }

                return num + ' ' + str2;
            },
            minPrice(num, str3 = ''){
                num = 1350000
                var str;
                var str2;

                if(String(num).length === 7){
                    str = String(num).slice(0, 1)
                    str2 = String(num).slice(1, 2)

                    str3 = 'от ' + str + '.' + str2 + ' млн руб.';
                }

                if(String(num).length === 8){
                    str = String(num).slice(0, 2)
                    str2 = String(num).slice(2, 3)

                    str3 = 'от ' + str + '.' + str2 + ' млн руб.';
                }

                return str3;
            },
            toReserve(id){
                this.$router.push({name: 'reserve' , params: { id: id } })
            },
            fetch(){
                this.$http.get('/api/objects')
                    .then(response=>{
                        this.objects = response.data.objects
                        this.currentObjects = response.data.currentObjects
                    })
            },
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
            toObject(id){
                this.$router.push({name: 'chooseHouse' , params: { id: id } })
            },
            toHouse(id){
                this.$router.push({name: 'chooseFloor' , params: { id: id } })
            },

        },
        created() {
            this.fetch();
        }
    }
</script>

<style scoped>
    /*.city-plan{*/
    /*    position: relative;*/
    /*}*/
</style>
