<template>
<div class="col-md-3 mb-3">
    <label v-if="label" :for="name" class="mb-1" >
        <b>
            {{ label }}:
            <span class="text-danger" v-if="required">*</span>
        </b>
    </label>

    <money3
        class="form-control"
        v-model.lazy="current_value"
        v-bind="config"
        :disabled="readonly"/>
</div>
</template>

<script>
import { Money3Component } from 'v-money3'

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
        modelValue: [String, Number],
        name: {
            type: String,
            default: () => '__input_text_name_'+Math.floor(Math.random()*10000)
        },
        errors: {
            type: Object
        },
    },

    data () {
        return {
            current_value: '',
            config: {
                masked: false,
                prefix: 'R$ ',
                suffix: '',
                thousands: '.',
                decimal: ',',
                precision: 2,
                disableNegative: false,
                disabled: false,
                min: null,
                max: null,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
                shouldRound: true,
                focusOnRight: false,
            }
        }
    },

    watch: {
        modelValue: {
            handler(value){
                if(value !== this.current_value){
                    this.current_value = value !== null? value+'' : ''
                }
            },
            immediate: true
        },
        current_value(value){
            if(value != this.modelValue)
                this.send()
        }
    },

    methods: {
        send(){
            console.log(this.current_value)
            this.$emit('update:modelValue', this.current_value)
        }
    },

    components: { money3: Money3Component },
}
</script>
