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
                Этажи
                <v-spacer></v-spacer>

                <v-btn :to="{name: 'adminFloorCreate'}" class="primary">
                    Добавить этаж
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
                        <th class="text-left">Этаж</th>
                        <th class="text-center">Подъезд</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id">
                        <td class="text-left">{{ item.name }}</td>
                        <td class="text-center">{{ item.porch }}</td>
                        <td class="text-right">
                            <router-link class="crud-icon-link" :to="{name: 'adminFloorShow', params: {id: item.id}}"><v-icon class="crud-icon-show" size="18">mdi-eye-outline</v-icon></router-link>
                            <router-link class="crud-icon-link" :to="{name: 'adminFloorEdit', params: {id: item.id}}"><v-icon class="crud-icon-edit" size="18">mdi-pencil</v-icon></router-link>
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
    import axios from 'axios'

    export default {
        name: "HouseShow",
        props: {
            successMsg: ''
        },
        data() {
            return {
                search: '',
                house: [],
                floors: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed: {
            filteredList: function () {
                var comp = this.search;
                return this.floors.filter(function (elem) {
                    if (comp === '') return true;
                    else return elem.name.indexOf(comp) > -1;
                })
            }
        },
        methods: {
            fetch() {
                axios.get('/api/houses/' + this.$route.params.id)
                    .then(response => {
                        this.floors = response.data.house.floorss;
                        this.house = response.data.house;
                    })
            },
            dlt(id) {
                if(window.confirm('Вы действительно хотите удалить этот этаж?'))
                {
                    axios.delete('/api/admin/deleteFloor/',{
                        params: {
                            floorId: id
                        }
                    })
                        .then(response=>{
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            this.floors = response.data.floors;
                        })
                }
            }
        },
        created() {
            this.fetch();

            if (this.sMsg !== undefined) {
                this.hasMsg = true;
            }
        }
    }
</script>
