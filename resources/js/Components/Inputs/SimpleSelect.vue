<template>
<div class="col-md-3 mb-3">
    <label v-if="label" :for="name" class="mb-1">
        <b>
            {{ label }}:
            <span class="text-danger" v-if="required">*</span>
        </b>
    </label>

    <select class="form-select"
        :name="name"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
        :disabled="readonly || !Object.keys(options).length">

        <option
            v-if="placeholder && !nothing_op"
            :value="null"
            disabled
            selected>
            {{ placeholder }}
        </option>

        <option
            v-if="nothing_op"
            :value="null">
            {{ placeholder || 'Nenhum'}}
        </option>

        <option
            v-for="(op, key) in options"
            :key="key"
            :value="key">
            {{ op }}
        </option>
    </select>
</div>
</template>

<script>
export default {
    props: {
        modelValue: [String, Number],
        readonly: {
            type: Boolean,
            default: false,
        },
        options: {
            type: Object,
            default: () => ({})
        },
        placeholder: String,
        nothing_op: {
            type: Boolean,
            default: false,
        },
        required: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: () => '__input_text_name_'+Math.floor(Math.random()*10000)
        },
    },

    watch: {
        options(){
            if(this.$el.value  != this.modelValue){
                this.$nextTick(() => {
                    this.$el.value = this.modelValue
                })
            }
        }
    }
}
</script>
