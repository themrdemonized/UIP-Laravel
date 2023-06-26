<template>
    <div class="plan-head" :class="{'contrast': isContrast, 'shadow': isShadow, 'bg-light' : isLight, 'opacity' : isOpacity}">
        <div class="plan-head-left" :class="{'opacity' : isOpacity}">
<!--            <div v-if="isHome" class="plan-head-left-home">-->
<!--                <span>-->
<!--                    Новые грани города-->
<!--                </span>-->
<!--                <br>-->

<!--                <span>-->
<!--                    "Управление инвистиционных программ"-->
<!--                </span>-->
<!--            </div>-->
            <div v-if="brad !== null" class="plan-head-left-brad">
                <span v-html="brad">
                </span>
            </div>
            <div class="plan-head-left-descr">
                <span v-if="bradLink !== true" v-html="title">
                </span>
                <router-link v-if="bradLink === true" :to="{name: bradLinkTo, params: bradLinkParams }">
                    <v-icon class="icon plan-head-left-icon">mdi-chevron-left</v-icon>
                    {{bradLinkToTitle}}
                </router-link>
            </div>
        </div>
        <div class="plan-head-right" :class="{'opacity' : isOpacity}">
            <div class="plan-head-right-link">
                <a title="Главный офис, приемная" href="tel:+7 (4212) 413-188">+7 (4212) 413-188</a>
            </div>
            <div class="plan-head-right-span">
                <span @click="showModal()">Заказать звонок</span>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "head_component",
        props:{
            brad: null,
            title: null,
            isContrast: false,
            isHome: false,
            isShadow: false,
            isLight: false,
            isOpacity: false,
            bradLink: false,
            bradLinkTo: null,
            bradLinkToTitle: null,
            bradLinkParams: {}
        },
        data(){
            return{

            }
        },
        methods: {
            showModal(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            },
        }
    }
</script>

<style scoped>
    .plan-head-left-home{
        color: #000000;
        font-size: .9rem;
        letter-spacing: unset;
    }
</style>
