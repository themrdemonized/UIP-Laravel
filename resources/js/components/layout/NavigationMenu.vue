<template>
    <div class="navigation">
        <div class="menu navigation__menu navigation__menu-shadow">

            <div class="logo navigation__logo">
                <router-link :to="{name: 'home'}" class="logo__link">
                    <img class="logo__img" src="/img/logo.png" alt="logo" >
                </router-link>
            </div>

            <div class="burger navigation__burger">
                <div class="burger__icon burger__icon_slip">
                    <div class="burger__lines"></div>
                </div>
            </div>

            <div class="call navigation__call">
                <v-icon @click="showModal">mdi-phone</v-icon>
            </div>
        </div>

        <nav class="push-menu navigation__push-menu">
            <div class="push-menu__head"></div>

            <div class="push-menu__body">
                <ul class="navigation-list push-menu__navigation-list">
                    <li class="navigation-list__element" v-for="link in links" :key="link.id + link.title">
                        <router-link class="navigation-list__link" :to="{name: link.name}">{{link.title}}</router-link>
                    </li>
                </ul>
            </div>

            <div class="push-menu__footer"></div>
        </nav>

        <div class="overflow navigation__overflow"></div>
    </div>
</template>

<script>
    export default {
        name: "NavigationMenu",
        data(){
            return{
                links: [
                    {id: 1, name: 'home', title: 'Главная'},
                    {id: 2, name: 'chooseObject', title: 'Объекты'},
                    {id: 3, name: 'flatList', title: 'Выбрать квартиру'},
                    {id: 4, name: 'commercial', title: 'Коммерческая недвижимость'},
                    {id: 5, name: 'news', title: 'Новости'},
                    {id: 6, name: 'about', title: 'О компании'},
                    {id: 7, name: 'achievements', title: 'Достижения'},
                    {id: 8, name: 'contacts', title: 'Контакты'},
                ]
            }
        },
        methods:{
            nav(){
                var hamburger = {
                    navToggle: document.querySelector('.burger__icon'),
                    nav: document.querySelector('.navigation__push-menu'),
                    opacity: document.querySelector('.navigation__overflow'),
                    menu: document.querySelector('.navigation__menu'),
                    ul: document.querySelector('.push-menu__navigation-list'),

                    doToggle: function(e) {
                        e.preventDefault();
                        this.navToggle.classList.toggle('open');
                        this.nav.classList.toggle('expanded');
                        this.opacity.classList.toggle('expanded');
                        this.menu.classList.toggle('navigation__menu-shadow');
                    }
                };

                hamburger.navToggle.addEventListener('click', function(e) { hamburger.doToggle(e); });
                hamburger.opacity.addEventListener('click', function(e) { hamburger.doToggle(e); });
                hamburger.ul.addEventListener('click', function(e) { hamburger.doToggle(e); });

            },
            showModal(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            },
        },
        mounted() {
            this.nav();
        }
    }
</script>

<style scoped>

    .navigation__menu{
        position: fixed;
        height: 100vh;
        width: 7vw;
        background-color: #fff;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        z-index: 1600;
    }
    .navigation__menu-shadow{
        -webkit-box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.1);
        box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.1);
        transition: box-shadow 1s ease-in-out
    }
    .logo__link{
        display: block;
    }
    .navigation__logo{
        padding: 1rem;
    }
    .navigation__burger, .navigation__logo, .navigation__call{
        width: 100%;
        height: 33.333%;
        display:flex;
        justify-content: center;
        align-items: center;
    }
    .logo__img{
        width: 100%;
    }
    .burger__icon {
        height: 3em;
        width: 3em;
        position: relative;
        font-size: 14px;
        cursor: pointer;
        -webkit-transition: .2s all;
        -o-transition: .2s all;
        transition: .2s all;
        -webkit-tap-highlight-color: transparent;
    }
    .burger__icon .burger__lines:after {
        left: 0;
        top: -1em;
    }
    .burger__icon .burger__lines:before {
        left: 1em;
        top: 1em;
    }
    .burger__icon:after {
        content: '';
        display: block;
        position: absolute;
        height: 150%;
        width: 150%;
        top: -25%;
        left: -25%;
    }
    .burger__icon .burger__lines {
        top: 50%;
        margin-top: -0.125em;
    }
    .burger__icon .burger__lines, .burger__icon .burger__lines:after, .burger__icon .burger__lines:before {
        pointer-events: none;
        display: block;
        content: '';
        width: 100%;
        border-radius: 0.25em;
        background-color: #444444;
        height: 0.25em;
        position: absolute;
        -webkit-transform: rotate(0);
        -ms-transform: rotate(0);
        transform: rotate(0);
    }
    .burger__icon .burger__lines:after {
        left: 0;
        top: -1em;
    }
    .burger__icon .burger__lines:before {
        left: 1em;
        top: 1em;
    }
    .burger__icon.burger__icon_slip .burger__lines:after, .burger__icon.burger__icon_slip .burger__lines:before {
        width: 2em;
    }
    .burger__icon.burger__icon_slip .burger__lines, .burger__icon.burger__icon_slip .burger__lines:after, .burger__icon.burger__icon_slip .burger__lines:before {
        -webkit-transition: all .2s;
        -o-transition: all .2s;
        transition: all .2s;
    }
    .burger__icon.burger__icon_slip.open .burger__lines {
        -webkit-transform: translateX(-2em);
        -ms-transform: translateX(-2em);
        transform: translateX(-2em);
        background-color: transparent;
    }
    .burger__icon.burger__icon_slip.open .burger__lines:before, .burger__icon.burger__icon_slip.open .burger__lines:after {
        left: 0.5em;
        top: 0px;
    }
    .burger__icon.burger__icon_slip.open .burger__lines:before {
        -webkit-transform: translateX(2em) rotate(135deg);
        -ms-transform: translateX(2em) rotate(135deg);
        transform: translateX(2em) rotate(135deg);
    }
    .burger__icon.burger__icon_slip.open .burger__lines:after {
        -webkit-transform: translateX(2em) rotate(-135deg);
        -ms-transform: translateX(2em) rotate(-135deg);
        transform: translateX(2em) rotate(-135deg);
    }
    .navigation__push-menu {
        -webkit-transition: left 0.3s ease;
        -moz-transition: left 0.3s ease;
        -ms-transition: left 0.3s ease;
        -o-transition: left 0.3s ease;
        transition: transform 0.3s ease;
        background: #fff;
        height: 100vh;
        /*left: -20rem;*/
        transform: translateX(-20rem);
        position: fixed;
        top: 0;
        width: 20rem;
        z-index: 1550;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        -webkit-box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.1);
        box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.1);
        color: #555555;
        padding: 1rem;
    }
    .navigation__push-menu.expanded { transform: translateX(6.98vw); }
    .navigation__overflow{
        position: fixed;
        top: 0;
        left:0;
        background-color: #333333;
        visibility: hidden;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 1500;
    }
    .navigation__overflow.expanded{
        visibility: visible;
        opacity: .6;
        transition: visibility 0s,opacity .4s ease-in-out;
    }


    .push-menu__body{
        width: 100%;
        display: flex;
        align-items: center;
    }

    .navigation-list{
        font-size: 1rem;
        line-height: 3;
    }

    .navigation-list__element{
        list-style-type: none;
    }

    .navigation-list__link{
        text-decoration: none;
        color: #333333;
    }
</style>
