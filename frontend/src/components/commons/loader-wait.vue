<template>
    <div class="loader-wrapper">
        <div class="loader">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p>{{ text }}</p>
    </div>
</template>

<script>
export default {

    name: "LoaderWait",

    props: {
        active: Boolean,
        text: String
    }
}
</script>

<style scoped>
p {
    font-size: 1.5em;
    font-weight: 500;
    margin-left: 10px;
    letter-spacing: 1px;
    color: #234148;
}

.loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    /* Fundo semi-transparente */
    display: flex;
    justify-content: center;
    /* Centraliza horizontalmente */
    align-items: center;
    /* Centraliza verticalmente */
    z-index: 9999;
}

.loader {
    display: inline-block;
    position: relative;
    width: 160px;
    height: 160px;
}

.loader div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 144px;
    height: 144px;
    margin: 6px;
    border: 20px solid #38E38B;
    border-radius: 50%;
    animation: loader 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: #38E38B transparent transparent transparent;
}

.loader div:nth-child(1) {
    animation-delay: -0.45s;
}

.loader div:nth-child(2) {
    animation-delay: -0.3s;
}

.loader div:nth-child(3) {
    animation-delay: -0.15s;
}

@keyframes loader {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>