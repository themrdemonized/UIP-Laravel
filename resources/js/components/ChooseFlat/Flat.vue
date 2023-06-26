<template>
    <div class="flat-box">

        <Head_component
            :brad="brad"
            :brad-link="true"
            brad-link-to="chooseFlat"
            brad-link-to-title="Вернуться к выбору квартиры"
            :brad-link-params="bradLinkParams"
        ></Head_component>

        <div class="body-flat">
            <div class="flat">
                <div id="pop-widget"></div>
            </div>
            <div class="flat-reserve">
                <div class="flat-reserve-info">
                    <div class="flat-info">
                        <div class="flat-info-name" v-if="flat.rooms === 0">
                            Студия №{{flat.name}}
                        </div>
                        <div class="flat-info-name" v-if="flat.rooms === 1">
                            Однокомнатная квартира №{{flat.name}}
                        </div>
                        <div class="flat-info-name" v-if="flat.rooms === 2">
                            Двухкомнатная квартира №{{flat.name}}
                        </div>
                        <div class="flat-info-name" v-if="flat.rooms === 3">
                            Трехкомнатная квартира №{{flat.name}}
                        </div>
                        <div class="flat-info-name" v-if="flat.rooms === 4">
                            Четырехкомнатная квартира №{{flat.name}}
                        </div>
                        <div class="flat-info-area">
                            <span class="color-secondary flat-info-area-title">Площадь</span>
                            <span class="color-primary">{{flat.area}}</span> <span class="color-secondary">м<sup>2</sup></span>
                        </div>
                        <div class="flat-info-place">
                            <div class="flat-info-place-house">
                                <span class="color-primary">{{houseName}}</span>
                                <span class="color-secondary">дом</span>
                            </div>
                            <div class="flat-info-place-floor">
                                <span class="color-primary">{{floorName}}</span>
                                <span class="color-secondary">этаж</span>
                            </div>
                        </div>

                        <div class="flat-info__date">
                            <span>
                                {{date}}
                            </span>
                        </div>

                        <div class="flat-info-price">
                            <span>{{Intl.NumberFormat('ru-RU').format(flat.coast)}}</span> ₽
                        </div>
                        <div class="flat-info-btn">
                            <v-btn @click="showModal('квартира', flat.id, flat.name)" class="v-flat-btn" :tile="true" :elevation="5">
                                Забронировать
                            </v-btn>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <reserve-component
            :object-reserve="this.objectToReserve"
            :object-id="this.objectToReserveId"
            :object-name="this.objectToReserveName"
        ></reserve-component>
    </div>
</template>

<script>
    import { mask } from 'vue-the-mask'
    import Head_component from "../layout/HeadComponent";
    import ReserveComponent from "../layout/ReserveComponent";

    export default {
        name: "Flat",
        components: {ReserveComponent, Head_component},
        directives:{
            mask,
        },
        data(){
          return{
              flat: [],
              floorName: null,
              houseName: null,
              objectName: null,
              uid: null,
              date: null,

              name: "",
              number: "",
              error: "",
              mask: '+7 (###) ### ## ##',

              bradLinkParams: {},

              objectToReserve: '',
              objectToReserveId: null,
              objectToReserveName: null,
          }
        },
        computed:{
            brad : function () {
                return this.objectName + ' - Дом ' + this.houseName + ' - Этаж ' + this.floorName + ' - Квартира №' + this.flat.name
            }
        },
        methods:{
            fetch(){
               this.$http.get('/api/flats/' + this.$route.params.id)
                   .then(response=>{
                        this.flat = response.data.flat
                        this.uid = response.data.flat.uid
                        this.date = response.data.flat.floorr.house.description
                        this.floorName = response.data.flat.floorr.name
                        this.houseName = response.data.flat.floorr.house.name
                        this.objectName = response.data.flat.floorr.house.object.name
                        this.bradLinkParams['id'] = response.data.flat.floor_id
                        this.bradLinkParams['name'] = Number(this.floorName)
                        this.plan()
                })
                   .catch(error=>{
                       if(error.response.status === 404){
                           this.$router.push('/404');
                       }
                   })
            },
            plan(){
                Planoplan.init({
                    width: '100%',
                    height: '100%',
                    primaryColor: '#3e4577',
                    secondaryColor: '#fafafa',
                    textColor: '#fff',
                    backgroundColor: 'unset',
                    fontFamily: 'Open Sans, sans-serif',
                    activeTab: 'top',
                    activeFloor: '0',
                    activeDesign: '873032',
                    uid: this.uid,
                    el: 'pop-widget',
                    lang: 'ru',
                    initialCamera: [
                        {
                            design: 873032,
                            floor: 1,
                            camera: 6
                        }]
                });

            },
            showModal(type, id, name){
                this.objectToReserve = type;
                this.objectToReserveId = id;
                this.objectToReserveName = name;

                var modal = document.querySelector('.modal-reserve')
                modal.classList.toggle('show')
            },

        },
        created(){
            this.fetch();
        }
    }
</script>

<style scoped>

</style>
