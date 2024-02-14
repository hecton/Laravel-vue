<template>
<div class="col-md-3 mb-3">
    <label v-if="label" :for="name" class="mb-1">
        <b>
            {{ label }}:
            <span class="text-danger" v-if="required">*</span>
        </b>
    </label>

    <input
        :name="name"
        :class="`form-control ${isValid}`"
        type="date"
        @input="emiter($event.target.value)"
        :value="date"
        :disabled="readonly">
</div>
</template>

<script>
export default {
    props: {
        modelValue: String,
        default_time: {
            type: String,
            default: '23:59:00'
        },
        label: {
            type: String,
            default: 'Data/Hora'
        },
        required: {
            type: Boolean,
            default: false
        },
        readonly: {
            type: Boolean,
            default: false,
        },
        time: {
            type: Boolean,
            default: false,
        },
        name: {
            type: String,
            default: () => '__input_text_name_'+Math.floor(Math.random()*10000)
        },
    },

    data(){
        return {
            date: null,
            v_data: /^(((0[1-9]|[12][0-9]|3[01])[- /.](0[13578]|1[02])|(0[1-9]|[12][0-9]|30)[- /.](0[469]|11)|(0[1-9]|1\d|2[0-8])[- /.]02)[- /.]\d{4}|29[- /.]02[- /.](\d{2}(0[48]|[2468][048]|[13579][26])|([02468][048]|[1359][26])00))$/,
            v_time: /^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])$/
        }
    },

    computed: {
        isValid(){
            return ''
            // var data = this.date? this.date.split('-').reverse().join('-') : null;
            // if(data === null)
            //     return '';
            // else{
            //     return this.v_data.test(data)? 'is-valid' : 'is-invalid';
            // }
        },
    },

    watch: {
        modelValue: {
            handler(e){
                if(e){
                    var datetime = e.split(' ');
                    this.date = datetime[0];
                }
            },
            immediate: true,

        }
    },

    methods: {
        emiter(value){
            if(this.time){
                var date = value? `${value} ${this.default_time}` : null
            }else{
                var date = value
            }
            this.$emit('update:modelValue', date);
        }
    },
}
</script>
