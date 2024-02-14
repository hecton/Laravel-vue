<script>
import SelectAjax from '@/Components/Inputs/SelectAjax.vue'

export default {
    props: {
        modelValue: [String, Number],

        label: String,
        name: {
            type: String,
            default: () => '__input_text_name_'+Math.floor(Math.random()*10000)
        },
        required: {
            type: Boolean,
            default: false
        },
        readonly: {
            type: Boolean,
            default: false,
        },
    },

    components: {
        SelectAjax
    }
}
</script>

<template>
    <select-ajax
        :modelValue="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        label="Status do pedido"
        title="descricao"
        index="id"
        url="/pedidos/status-pedidos"
        :readonly="readonly"
        :name="name"
    />
</template>
