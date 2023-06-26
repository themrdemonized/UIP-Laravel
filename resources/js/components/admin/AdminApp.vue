<template>
        <v-app app>
            <v-navigation-drawer
                v-model="drawer"
                app
                clipped
            >
                <v-list dense>
                    <v-list-item
                        v-for="item in items"
                        :key="item.text"
                        link
                        :to="item.link"
                    >
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

            </v-navigation-drawer>

            <v-app-bar
                app
                clipped-left
                color="red"
                dense
            >
                <v-app-bar-nav-icon @click.stop="drawer = !drawer" />

                <v-spacer></v-spacer>

                <v-icon @click.prevent="$auth.logout()">mdi-door</v-icon>

            </v-app-bar>

            <v-content>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-content>
        </v-app>
</template>

<script>
    export default {
        name: "AdminApp",
        data(){
            return{
                newCalls: 5,
                items: [
                    { icon: 'mdi-view-dashboard', text: 'Информационная панель', link: {name: 'adminDashboard'}},
                    { icon: 'mdi-home-city', text: 'Объекты', link: {name: 'adminObjects'} },
                    { icon: 'mdi-magnify', text: 'Найти квартиру', link: {name: 'adminFindFlat'} },
                    { icon: 'mdi-office-building', text: 'Офисы', link: {name: 'adminOfficeShow'} },
                    { icon: 'mdi-package-variant-closed', text: 'Кладовки', link: {name: 'adminPantryShow'} },
                    { icon: 'mdi-phone', text: 'Обратный звонок', link: {name: 'adminRequests'}},
                    { icon: 'mdi-home-lock', text: 'Бронирование', link: {name: 'adminReserves'} },
                    { icon: 'mdi-currency-rub', text: 'Цены', link: {name: 'adminPrices'} },
                    { icon: 'mdi-newspaper-variant', text: 'Новости', link: {name: 'adminNews'} },
                    { icon: 'mdi-file-document', text: 'Документы', link: {name: 'adminDocuments'} },
                    { icon: 'mdi-camera', text: 'Фотоотчеты', link: {name: 'photoReports'} },
                    { icon: 'mdi-camera', text: 'Аккредитация', link: {name: 'adminBanks'} },
                    { icon: 'mdi-account', text: 'Пользователи', link: {name: 'adminUsers'} },
                ],
                drawer: true
            }
        }
    }
</script>

<style scoped>

</style>
