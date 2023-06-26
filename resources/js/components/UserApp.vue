<template>
        <div>
<!--            <div class="navigation">-->
<!--                <div class="navigation-menu navigation-menu-shadow">-->
<!--                    <div class="logo">-->
<!--                        <router-link :to="{name: 'home'}">-->
<!--                            <img style="width: 100%;" src="/img/logo.png" alt="">-->
<!--                        </router-link>-->
<!--                    </div>-->
<!--                   <div class="nav-toggle">&ndash;&gt;-->
<!--                        <div class="nav-toggle-bar"></div>&ndash;&gt;-->
<!--                   </div>&ndash;&gt;-->
<!--                    <div class="box-burger">-->
<!--                        <div class="burger burger-slip">-->
<!--                            <div class="burger-lines"></div>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                </div>-->

<!--                <nav class="nav">-->
<!--                    <div class="navigation-menu-expanded">-->
<!--                        <div class="navigation-menu-head">-->
<!--                            <div>-->
<!--                                <div class="navigation-menu-head-contacts">-->
<!--                                    <div style="margin-bottom: .5rem;">-->
<!--                                        <a href="tel:+7-(424)-111-222">+7 (4212) 413-413</a> <br>-->
<!--                                        <span>Отдел продаж ЖК "Петроглиф парк"</span>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <a href="tel:+7-(424)-111-222">+7 (4212) 413-414</a> <br>-->
<!--                                        <span>Отдел продаж ЖК "Восточный парк"</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="navigation-menu-head-callback">-->
<!--                                    <span @click="showModal">Заказать звонок</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="navigation-menu-body">-->
<!--                            <div class="navigation-menu-body-ul">-->
<!--                                <ul id="ul">-->
<!--                                    <li><router-link to="/">Главная</router-link></li>-->
<!--                                    <li><router-link to="/chooseObject">Объекты</router-link></li>-->
<!--                                    <li><router-link to="/flatList">Выбрать квартиру</router-link></li>-->
<!--                                    <li><router-link to="/news">Новости</router-link></li>-->
<!--                                    <li><router-link to="/about">О компании</router-link></li>-->
<!--                                    <li><router-link to="/achievements">Достижения</router-link></li>-->
<!--                                    <li><router-link to="/contacts">Контакты</router-link></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="navigation-menu-footer">-->
<!--                            <v-icon class="v-social-link">-->
<!--                                mdi-instagram-->
<!--                            </v-icon>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </nav>-->

<!--                <div class="navigation-menu-opacity"></div>-->
<!--            </div>-->

            <navigation-menu></navigation-menu>

            <call-component></call-component>

            <div class="main">
                <router-view></router-view>
            </div>

        </div>
</template>


<script>
    import FormFlatList from "./ChooseFlat/FormFlatList";
    import CallComponent from "./layout/CallComponent";
    import NavigationMenu from "./layout/NavigationMenu";

    export default {
        name: 'UserComponent',
        components: {NavigationMenu, CallComponent, FormFlatList},
        data () {
            return {
                drawer: false,
                msg: null,
            }
        },
        methods:{

            showModal(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            },
        },
        mounted() {
        }
    }
</script>

<style scoped>

</style>
