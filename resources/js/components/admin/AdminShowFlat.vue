<template>
    <div>
        <v-card style="height: 100vh; position: relative">
            <v-card-title style="z-index: 2; position: absolute; top: 0; left: 0; width: 100%">
                <v-row>
                    <v-col cols="3">
                        Квартира №{{flat.name}}
                    </v-col>
                    <v-spacer>
                    </v-spacer>
                    <v-col cols="3">
                        <v-select
                            :items="status"
                            item-text="name"
                            item-value="id"
                            v-model="selectStatus"
                            label="Выберите статус"
                            @change="changeStatus()"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div class="v-card-planoplan">
                    <div id="pop-widget"></div>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "AdminShowFlat",
        data(){
            return{
                flat: [],
                selectStatus: null,
                status: [
                    { id: 1, name: 'Свободна'},
                    { id: 2, name: 'Продана'},
                    { id: 3, name: 'Забронирована'},
                ],
            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/editFlat', {
                    params: {
                        flatId: this.$route.params.id
                    }
                })
                    .then(response =>{
                        this.flat = response.data.flat;
                        this.selectStatus = response.data.flat.status_id
                    })
            },
            changeStatus(){
                axios.get('/api/admin/changeFlatStatus', {
                    params: {
                        flatId: this.flat.id,
                        selectStatus: this.selectStatus
                    }
                })
                    .then(response =>{
                        this.$router.push({name: 'adminFindFlat', params: {successMsg: response.data.msg}});
                    })
            },
            plan() {
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
                    uid: '25945b4390000326fc1475c1b00008ae',
                    el: 'pop-widget',
                    lang: 'ru',
                    initialCamera: [
                        {
                            design: 873032,
                            floor: 1,
                            camera: 6
                        }]
                });
            }
        },
        created() {
            this.fetch();
        },
        mounted() {
            this.plan();
        }
    }
</script>

<style scoped>

</style>
