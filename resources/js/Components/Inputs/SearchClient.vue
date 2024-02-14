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
        modelValue: [String, Number],
        name: {
            type: String,
            default: () => '__input_text_name_'+Math.floor(Math.random()*10000)
        },
        errors: {
            type: Object
        },
    },

    data(){
        return {
            data: null,
            load: true,
            search: null,
            show_options: false,
            current_value: null
        }
    },

    computed: {
        options(){

            let data =  (this.data??[]);
            if(this.search){
                var search = this.search.match(RegExp(this.search.toLocaleLowerCase()))
                return data.filter(i => {
                    let nome = i.nome.toLocaleLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "")
                    return nome.match(search) || i.nome == this.search
                }).slice(0, 7);

            }

            return data.slice(0, 7);
        }
    },

    watch: {
        modelValue: {
            handler(value){
                if(value != this.current_value && this.data){
                    this.current_value = value
                    this.search = this.data.find(i => i.id == value)?.nome
                }
            },
            immediate: true
        },

        data(){
            this.setSearchSelectedOption()
        }
    },

    created(){
        this.getData();
    },

    methods: {
        setSearchSelectedOption(){
            if(this.data && this.modelValue){
                this.search = this.data.find(i => i.id == this.modelValue)?.nome
            }
        },

        send(value){
            this.current_value = value;
            this.$emit('update:modelValue', value)
        },

        setNull(){
            this.send(null)
            this.search = null
        },

        setToSearch(){
            this.show_options = true
            this.search = null
        },

        setOption(client){
            this.send(client.id)
            this.show_options = false
            this.search = client.nome
        },

        showSelectOption(){
            this.$nextTick(() => {
                if(!this.modelValue){
                    this.search = null
                }

                if(this.show_options){
                    setTimeout(() => {
                        this.show_options = false
                        this.setSearchSelectedOption()
                    }, 200)
                }
            })
        },

        setFocus(){
            this.$el.querySelector('input').focus()
            this.setToSearch()
        },

        async getData(){
            this.load = true
            try {
                var response  = await axios.get('/clientes/getAll');
                this.data = response.data
            }catch(err) {
                console.error('Erro ao buscar clientes', err)
            }
            this.load = false;
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

    <div class="input-group mb-3">
        <input
            type="text"
            class="form-control"
            v-model="search"
            :disabled="readonly || load"
            @click="setToSearch()"
            @focusout="showSelectOption()"
            placeholder="Pesquise aqui"
            >

        <ul :class="{
            'dropdown-menu': true,
            'show': show_options,
            'mt-5': true}">

            <li v-for="option in options" :key="option.id" @click.prevent="setOption(option)">
                <span class="dropdown-item">{{ option.nome }}</span>
            </li>

            <li v-if="!options.length">
                <span class="dropdown-item">Nada encontrado</span>
            </li>

        </ul>

        <button
            type="button"
            class="btn btn-secondary"
            v-if="!modelValue"
            @click="setFocus()"
            :disabled="readonly || load">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <button type="button" class="btn btn-danger" v-else @click="setNull()">X</button>
    </div>
</div>
</template>
