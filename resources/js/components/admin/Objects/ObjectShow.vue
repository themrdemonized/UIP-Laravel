<template>
    <div>
        <div v-if="hasMsg">
            <v-alert v-model="hasMsg" text dismissible type="success">
                {{sMsg}}
            </v-alert>
        </div>

        <div v-if="hasError">
            <v-alert v-model="hasError" text dismissible type="error">
                I'm a error alert.
            </v-alert>
        </div>

        <v-card>
            <v-card-title>
                {{object.name}} - Дома
                <v-spacer></v-spacer>

                <v-btn :to="{name: 'adminHouseCreate'}" class="primary">
                    Добавить дом
                </v-btn>
            </v-card-title>
            <v-card-subtitle>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-search"
                    label="Найти"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-subtitle>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">№ Дома</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td class="text-right">
                            <router-link class="crud-icon-link" :to="{name: 'adminHouseShow', params: {id: item.id}}"><v-icon class="crud-icon-show" size="18">mdi-eye-outline</v-icon></router-link>
                            <router-link class="crud-icon-link" :to="{name: 'adminHouseEdit', params: {id: item.id}}"><v-icon class="crud-icon-edit" size="18">mdi-pencil</v-icon></router-link>
                            <router-link class="crud-icon-link" to="#"><v-icon @click="dlt(item.id)" class="crud-icon-delete" size="18">mdi-delete</v-icon></router-link>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card>
    </div>
</template>

<script>
    export default {
        name: "ObjectShow",
        props:{
            successMsg: ''
        },
        data(){
            return {
                search: '',
                object: [],
                houses: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.houses.filter(function (elem) {
                    if(comp==='') return true;
                    else return elem.name.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            fetch(){
                this.$http.get('/api/objects/' + this.$route.params.id)
                    .then(response=>{
                        this.object = response.data.object;
                        this.houses = response.data.object.houses;
                    })
            },
            dlt(id){
                if(window.confirm('Вы действительно хотите удалить это здание?'))
                {
                    this.$http.delete('/api/admin/deleteHouse/',{
                        params: {
                            houseId: id
                        }
                    })
                        .then(response=>{
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            this.houses = response.data.houses;
                        })
                }
            }
        },
        created() {
            this.fetch();

            if(this.sMsg !== undefined){
                this.hasMsg = true;
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
