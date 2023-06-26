<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Фотоотчет {{photoReportName}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <form @submit.prevent="upd">
                        <div>
                            <v-text-field label="Название" v-model="photoReportName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.photoReportName">{{ errors.photoReportName }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="houses"
                                v-model="photoReportHouse"
                                label="Дом"
                                item-value="id"
                            >
                                <template slot="selection" slot-scope="houses">
                                    {{ houses.item.name }}, {{ houses.item.object.name }}
                                </template>
                                <template slot="item" slot-scope="houses">
                                    {{ houses.item.name }}, {{ houses.item.object.name }}
                                </template>
                            </v-select>
                            <span class="help-block" v-if="hasError && errors.photoReportHouse">{{ errors.photoReportHouse }}</span>
                        </div>


                        <div>
                            <div>
                                <v-label>Текущие фотографии</v-label>
                            </div>
                            <div>
                                <viewer style="width: 100%; display: flex; flex-wrap: wrap" :images="currentPhoto" >
                                    <div class="photo-report-img-card" v-for="photo in currentPhoto">
                                        <div @click="dltImg(photo.id)" class="delete-icon">х</div>
                                        <img style="object-fit: cover; height: 100%; width: 100%" :src="'/' +photo.path" :key="photo.path">
                                    </div>
                                </viewer>
                            </div>
                        </div>

                        <div>
                            <v-file-input multiple v-model="attachments" label="Добавить фотографии"></v-file-input>
                            <span class="help-block" v-if="hasError && errors.attachments">{{ errors.attachments }}</span>
                        </div>

                        <div style="width: 100%; height: 50px">
                            <v-btn type="submit" class="primary float-right">Сохранить</v-btn>
                        </div>
                    </form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import axios from 'axios'

    export default {

        name: "photoReportEdit",
        data(){
            return{
                photoReportId: null,
                photoReportName: "",
                photoReportHouse: null,
                houses: [],
                attachments: [],
                currentPhoto: [],

                errors: [],
                hasError: false,
                sMsg: null,
                hasMsg: false,
            }
        },
        methods:{
            fetch(){
                axios.get('/api/getHouses')
                    .then(response=>{
                        this.houses = response.data.houses;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
                axios.get('/api/admin/editPhotoReports',{
                    params: {
                        photoReportId: this.$route.params.id
                    }
                })
                    .then(response=>{
                        this.photoReportName = response.data.photoReport.title;
                        this.photoReportHouse = response.data.photoReport.house_id;
                        this.currentPhoto = response.data.photoReport.photo;
                    })
            },

            upd(){
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                formData.append('photoReportId', this.$route.params.id)
                formData.append('photoReportName', this.photoReportName)
                formData.append('photoReportHouse', this.photoReportHouse)
                for(let i=0; i<this.attachments.length; i++){
                    formData.append('images[]', this.attachments[i]);
                }
                axios.post('/api/admin/updatePhotoReports', formData , config )
                    .then(response=>{
                        this.$router.push({name: 'photoReports', params: {successMsg: response.data.msg} });
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    });
            },



            dltImg(id){
                function dltImgBloc(item) {
                    item.parentNode.classList.add('disable')
                }

                var imgBlock = event.currentTarget;

                if(window.confirm('Вы действительно хотите удалить эту фотографию?'))
                {
                    axios.delete('/api/admin/attachments/' + id)
                        .then(response=>{
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            dltImgBloc(imgBlock);
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.sMsg = error.response.data.msg;
                        })
                }
            }
        },
        created() {
            this.fetch();
        }
    }
</script>

<style scoped>
    .delete-icon{
        position: absolute;
        top:0;
        right: 0;
        display:flex;
        border-radius: 30px;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 30px;
        color: #fff;
        background-color: #ff5451;
    }
    .delete-icon:hover{
        cursor: pointer;
        opacity: .8;
    }
    .photo-report-img-card{
        display: block;
        padding: 1rem;
        width: 20%;
        position: relative;
    }
    .photo-report-img-card.disable{
        display: none;
    }
</style>
