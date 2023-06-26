<template>
    <div class="news__body">
        <div class="news__row">
            <div v-for="nw in news" class="new-card news__new-card" :key="nw.title">
                <router-link class="new-card__link" :to="{name: 'showNew', params: {id: nw.id}}">
                    <div class="new-card__body" @mouseenter="newOpacity" @mouseleave="newOpacity">
                        <div class="new-card__text" >
                            <div class="new-card__date">{{getDate(nw.created_at)}}</div>
                            <div class="new-card__title">{{nw.title}}</div>
                        </div>
                        <div class="new-card__img">
                            <img :src="'/' + nw.photo.path" :alt="nw.title">
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewsComponent",
        data(){
            return{
                news: [],
            }
        },
        methods:{
            fetch(){
                this.$http.get('/api/news')
                    .then(response=>{
                        this.news = response.data.news
                    })
            },
            newOpacity(){
                var el = event.currentTarget;
                el.querySelector('.new-card__img').classList.toggle('new-card__img_opacity')
            },
            getDate(date){
                var day = date.slice(8,10)
                var month = date.slice(5, 7);
                var year = date.slice(0,4)

                switch(month)
                {
                    case '01':
                        month = "Января"
                        break;
                    case '02':
                        month = "Февраля"
                        break;
                    case '03':
                        month = "Марта"
                        break;
                    case '04':
                        month = "Апреля"
                        break;
                    case '05':
                        month = "Мая"
                        break;
                    case '06':
                        month = "Июня"
                        break;
                    case '07':
                        month = "Июля"
                        break;
                    case '08':
                        month = "Августа"
                        break;
                    case '09':
                        month = "Сентября"
                        break;
                    case '10':
                        month = "Октября"
                        break;
                    case '11':
                        month = "Ноября"
                        break;
                    case '12':
                        month = "Декабря"
                        break;
                }

                return day + ' ' + month + ' ' + year
            },
        },
        created() {
            this.fetch();
        }
    }
</script>

<style scoped>

</style>
