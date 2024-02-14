<script setup>
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    title: {
        type: String,
    }
})
</script>


<template>
<div>
    <Navbar/>

    <div class="container-xxl bd-gutter mt-3 my-md-4">
        <main class="bd-main order-1 py-4">
            <div class="col-md-10 offset-1">
                <h1 v-if="title" class="mb-3 px-1">
                    {{title}}
                </h1>


                <div class="row">
                    <div class="col-12">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </main>
    </div>

</div>
</template>
