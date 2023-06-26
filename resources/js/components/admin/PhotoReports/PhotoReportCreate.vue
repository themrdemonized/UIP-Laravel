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
                    <form @submit.prevent="crt">
                        <div>
                            <v-text-field label="Название" v-model="photoReportName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.photoReportName">{{ errors.photoReportName }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="houses"
                                v-model="photoReportHouse"
                                label="Дом"
                                item-text="name"
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

                        <div class="form-group">
                            <div class="custom-file">
                                <v-file-input multiple v-model="attachments" label="Выберите фотографии"></v-file-input>
                                <span class="help-block" v-if="hasError && errors.attachments">{{ errors.attachments }}</span>
                            </div>
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

        name: "photoReportCreate",
        data(){
            return{
                photoReportName: "",
                photoReportHouse: null,
                houses: [],
                attachments: [],

                errors: [],
                hasError: false,
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
            },

            crt(){
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                for(let i=0; i<this.attachments.length; i++){
                    formData.append('images[]', this.attachments[i]);
                }
                formData.append('photoReportName', this.photoReportName)
                formData.append('photoReportHouse', this.photoReportHouse)

                axios.post('/api/admin/createPhotoReports', formData , config )
                    .then(response=>{
                        this.$router.push({name: 'photoReports', params: {successMsg: response.data.msg} });
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },
        created() {
            this.fetch();
        }
    }
</script>
