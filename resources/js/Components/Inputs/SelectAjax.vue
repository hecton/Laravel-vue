<template>
<div class="col-md-3 mb-3">
    <label v-if="label" :for="name" class="mb-1" >
        <b>
            {{ label }}:
            <span class="text-danger" v-if="required">*</span>
        </b>
    </label>

    <select
        class="form-select"
        :disabled="readonly || load"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        :name="name">
        <option :value="null" disabled selected>Selecione uma opção</option>

        <option
            v-for="option in options"
            :key="option[index]"
            :value="option[index]">

            {{ option[title] }}
        </option>
    </select>
</div>
</template>

<script>

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
        title: {
            type: String,
            default: 'name',
        },
        index: {
            type: String,
            default: 'id',
        },
        placeholder: String,
        url: {
            type: String,
            requred: true,
        },
        map: Function,
        readonly: {
            type: Boolean,
            default: false,
        },
    },

    data(){
        return {
            data: null,
            load: false,

        }
    },

    watch: {
        url: {
            handler() {
                this.getData()
            },
            immediate: true
        },
    },

    computed: {
        options() {
            if(!this.data) return []

            var options =  this.map? this.data.map(this.map)  : this.data;

            return options;
        }
    },

    methods: {
        async getData(){
            this.load = true
            try {
                var res  = await axios.get(this.url);
                this.data = Array.isArray(res.data)? res.data : [];
                this.$nextTick(() => this.$forceUpdate())
            }catch(err) {
                console.error('SelectAjax: Erro ao buscar dados ', err)
            }
            this.load = false;
        }
    }
}
</script>
