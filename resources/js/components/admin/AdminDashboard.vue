<template>
    <div>
        <div class="dashboard-box">
            <div class="dashboard-row">
                <div class="dashboard-col">
                    <router-link :to="{name: 'adminFindFlat', params: {pFlatStatus: 1}}">
                        <div class="dashboard-card dashboard-card-flats">
                            <div class="dashboard-card-text">
                                <v-icon class="theme--dark">
                                    mdi-home
                                </v-icon>
                                Квартир в продаже: {{flats}}
                            </div>
                        </div>
                    </router-link>
                </div>

                <div class="dashboard-col">
                    <router-link :to="{name: 'adminRequests'}">
                        <div class="dashboard-card dashboard-card-calls">
                            <div class="dashboard-card-text">
                                <v-icon class="theme--dark">
                                    mdi-phone
                                </v-icon>
                                Новых звонков: {{calls}}
                            </div>
                        </div>
                    </router-link>

                </div>

                <div class="dashboard-col">
                    <router-link :to="{name: 'adminReserves'}">
                    <div class="dashboard-card dashboard-card-reserves">
                        <div class="dashboard-card-text ">
                            <v-icon class="theme--dark">
                                mdi-home-lock
                            </v-icon>
                            Новых броней: {{reserves}}
                        </div>
                    </div>
                    </router-link>
                </div>

                <div class="dashboard-col">
                    <router-link :to="{name: 'adminNews'}">
                        <div class="dashboard-card dashboard-card-news">
                            <div class="dashboard-card-text">
                                <v-icon class="theme--dark">
                                    mdi-newspaper-variant
                                </v-icon>
                                Новостей всего: {{news}}
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "AdminDashboard",
        data(){
            return{
                flats: null,
                calls: null,
                reserves: null,
                news: null

            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/getDash')
                    .then(response=>{
                        this.flats = response.data.flatsInSold
                        this.calls = response.data.calls
                        this.reserves = response.data.reserves
                        this.news = response.data.news
                    })
            }
        },
        created() {
            this.fetch()
        }
    }
</script>

<style scoped>

</style>
