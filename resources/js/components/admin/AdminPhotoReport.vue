<template>
    <div>
        <div v-if="hasMsg">
            <v-alert v-model="hasMsg" text dismissible type="success">
                {{sMsg}}
            </v-alert>
        </div>
        <div v-if="hasError">
            <v-alert v-model="hasError" text dismissible type="error">
                {{err}}
            </v-alert>
        </div>

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="2" style="display: flex; align-items: center; margin-right: 5rem">
                        Фотоотчеты
                    </v-col>
                    <v-spacer>
                    </v-spacer>
                    <v-col cols="3">
                        <v-btn :to="{name: 'photoReportsCreate'}" class="primary">
                            Добавить фотоотчет
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-subtitle>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-search"
                            label="Найти"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-subtitle>

            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Название</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id" >
                        <td class="text-left">{{ item.title }}</td>
                        <td class="text-right">
                            <v-icon @click="$router.push({name: 'photoReportsEdit', params: { id: item.id } })" class="crud-icon-edit" size="18">mdi-pencil</v-icon>
                            <v-icon @click="dlt(item.id)" class="crud-icon-delete" size="18">mdi-delete</v-icon>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card>
    </div>

</template>

<script>
    import axios from 'axios'

    export default {
        name: "AdminDocuments",
        props:{
            successMsg: ''
        },
        data(){
            return {
                search: '',
                photoReports: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.photoReports.filter(function (elem) {
                    if(comp==='') return true;
                    else return elem.title.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            dlt(id){
                if(window.confirm('Вы действительно хотите удалить этот Фотоотчет?'))
                {
                    axios.delete('/api/admin/deletePhotoReports',{
                        params: {
                            photoReportId: id
                        }
                    })
                        .then(response=>{
                            this.hasMsg = true;
                            this.photoReports = response.data.photoReports;
                            this.sMsg = response.data.msg;
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.sMsg = error.response.data.msg;
                        })
                }
            },
            fetch(){
                axios.get('/api/admin/getPhotoReports')
                    .then(response=>{
                        this.photoReports = response.data.photoReports
                    })
            },
        },
        created() {
            this.fetch();
        },
        mounted() {
            if(this.sMsg !== undefined){
                this.hasMsg = true;
            }
        }
    }
</script>

<style scoped>
    .crud-icon-link{
        text-decoration: none;
    }
    .crud-icon-show:hover{
        color: #38c172;
    }
    .crud-icon-edit:hover{
        color: #3490dc;
    }
    .crud-icon-delete:hover{
        color: #e3342f;
    }
    .doc-category:hover{
        cursor: pointer;
        color: #6cb2eb;
    }
</style>
