<template>
    <div style="position: relative;">

        <Head_component
            title="Новости"
            :isShadow="true"
            :isLight="true"
        ></Head_component>

        <div class="news-row">
            <news-component></news-component>
        </div>

    </div>
</template>

<script>
    import Head_component from "./layout/HeadComponent";
    import NewsComponent from "./layout/NewsComponent";

    export default {
        name: "News",
        components: {NewsComponent, Head_component},
    }
</script>

<style scoped>

</style>
