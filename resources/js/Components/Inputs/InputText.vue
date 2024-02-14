<script>
export default {
    props: {
        readonly: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ''
        },
        modelValue: String,
        name: {
            type: String,
            default: () => '__input_text_name_'+Math.floor(Math.random()*10000)
        },
        errors: {
            type: Object
        },
        mask: [String, Array],
    },


    methods: {
        send(e){
            this.$emit('update:modelValue', e.target.value)
        }
    }

}
</script>

<template>
<div class="col-md-3 mb-3">
    <label v-if="label" :for="name" class="mb-1" >
        <b>
            {{ label }}:
            <span class="text-danger" v-if="required">*</span>
        </b>
    </label>

    <input
        v-if="mask"
        type="text"
        :value="modelValue"
        :name="name"
        @input="send($event)"
        class="form-control"
        v-mask="mask"

        :disabled="readonly">
    <input
        v-else
        type="text"
        :value="modelValue"
        :name="name"
        @input="send($event)"
        class="form-control"
        :disabled="readonly">
</div>
</template>
