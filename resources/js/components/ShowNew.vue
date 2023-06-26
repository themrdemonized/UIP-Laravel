<template>
    <div style="position: relative;">

        <Head_component
            title="Новости"
            :isShadow="true"
            :isLight="true"
        ></Head_component>

        <div class="new-row">
            <div class="new-box">
                <div class="new-card">
                    <div class="new-title">
                        {{nw.title}}
                    </div>

                    <div class="new-card-photo">
                        <img :src="'/'+ photo.path" v-viewer="{title: false, scalable: false}">
                    </div>

                    <div class="new-card-text" v-html="nw.text">

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import Head_component from "./layout/HeadComponent";
    import FooterComponent from "./layout/FooterComponent";

    export default {
        components: {FooterComponent, Head_component},
        name: "ShowNew",
        data(){
            return{
                nw: [],
                photo: []
            }
        },
        methods:{
            fetch(){
                axios.get('/api/news/' + this.$route.params.id)
                    .then(response=>{
                        this.nw = response.data.new
                        this.photo = response.data.new.photo
                })
            },

        },
        created() {
            this.fetch()
        }
    }
</script>

<style scoped>

</style>
