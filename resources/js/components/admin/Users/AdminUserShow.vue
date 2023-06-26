<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Пользователь: {{userEmail}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field label="Имя" v-model="userName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.userName">{{ errors.userName }}</span>
                        </div>

                        <div>
                            <v-text-field label="Email" v-model="userEmail"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.userEmail">{{ errors.userEmail }}</span>
                        </div>

                        <v-checkbox
                            v-model="checkbox"
                            label="Подписать на рассылку забронированных квартир"
                        ></v-checkbox>

                        <div>
                            <v-select
                                :items="objects"
                                item-text="name"
                                item-value="id"
                                v-model="userObject"
                                label="Жилой комплекс"
                                :disabled="!checkbox"
                                multiple
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.userObject">{{ errors.userObject }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="roles"
                                item-text="name"
                                item-value="id"
                                v-model="userRole"
                                label="Роль"
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.userRole">{{ errors.userRole }}</span>
                        </div>

                        <div style="width: 100%; height: 50px">
                            <v-btn class="primary float-right" @click="upd()">Сохранить</v-btn>
                        </div>

                        {{userObject}}


                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import axios from 'axios'

    export default {

        name: "AdminUserShow",
        data(){
            return{
                userId: null,
                userName: '',
                userEmail: '',
                userObject: [],
                userRole: null,
                objects: [],
                roles: [
                    {id: 1, name: 'Пользователь'},
                    {id: 2, name: 'Менеджер'},
                    {id: 3, name: 'Администратор'}
                ],
                checkbox: false,
                errors: [],
                hasError: false,
            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/getUser',{
                    params: {
                        userId: this.$route.params.id
                    }
                })
                    .then(response=>{
                        this.userId = response.data.user.id;
                        this.userName = response.data.user.name;
                        this.userEmail = response.data.user.email;

                        if(response.data.user.objects.length > 0){
                            this.checkbox = true;
                        }

                        for(var obj in response.data.user.objects){
                            this.userObject.push(response.data.user.objects[obj].id);
                        }


                        this.userRole = response.data.user.role;
                        this.objects = response.data.objects;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            upd(){
                axios.post('/api/admin/updateUser',{
                    userId: this.userId,
                    userName: this.userName,
                    userEmail: this.userEmail,
                    userObject: this.userObject,
                    userRole: this.userRole
                })
                    .then(response=>{
                        this.$router.push({name: 'adminUsers', params: {successMsg: response.data.msg}});
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

<style scoped>

</style>
