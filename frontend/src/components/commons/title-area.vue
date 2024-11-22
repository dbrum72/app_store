<template>
    <div class="titleArea">
        <div>{{ title }}</div>
    </div>
</template>

<script>

export default {

    name: 'TitleArea',

    props: {
        title: String
    }
}

</script>

<style scoped>
.titleArea {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin-bottom: 10px;
    padding: 5px 10px;
    color: #fff;
    /*background: linear-gradient(90deg, rgb(44, 139, 102) 20%, rgba(56,227,139,1) 80%);*/
    background: linear-gradient(90deg, rgba(65, 184, 131, 1) 20%, rgba(53, 73, 94, 1))
}
</style>
