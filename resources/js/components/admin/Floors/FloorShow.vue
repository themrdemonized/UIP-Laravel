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
                Квартиры
                <v-spacer></v-spacer>

                <v-btn :to="{name: 'adminFlatCreate'}" class="primary">
                    Добавить квартиру
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
                        <th class="text-left">Квартира</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td class="text-right">
                            <router-link class="crud-icon-link" :to="{name: 'adminFlatEdit', params: {id: item.id}}"><v-icon class="crud-icon-edit" size="18">mdi-pencil</v-icon></router-link>
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
        name: "FloorShow",
        props: {
            successMsg: ''
        },
        data() {
            return {
                search: '',
                flats: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed: {
            filteredList: function () {
                var comp = this.search;
                return this.flats.filter(function (elem) {
                    if (comp === '') return true;
                    else return elem.name.indexOf(comp) > -1;
                })
            }
        },
        methods: {
            fetch() {
                axios.get('/api/admin/getFlats', {
                    params: {
                        floorId: this.$route.params.id
                    }
                })
                    .then(response => {
                        this.flats = response.data.flats;
                    })
            },
            dlt(id) {
                if(window.confirm('Вы действительно хотите удалить эту квартиру?'))
                {
                    axios.delete('/api/admin/deleteFlat/',{
                        params: {
                            flatId: id
                        }
                    })
                        .then(response=>{
                            this.flats = response.data.flats;
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
        },
        mounted() {

        }
    }
</script>
