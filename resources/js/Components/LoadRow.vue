<template>
    <div :class="`col-md-12 load-row ${error? 'error-load' : ''}`">
        <p class="secondary-text title-load"></p>
        <div class="loading-row">
            <div class="infinite-load"></div>
        </div>
        <p class="secondary-text error-title" @click="emmitRetry">
            Click para tentar novamente
        </p>
    </div>
</template>

<script>
export default {
    props: {
        error: {
            type: Boolean,
            default: false
        }
    },

    methods: {
        emmitRetry(){
            this.$emit('retry');
        }
    },
}
</script>
