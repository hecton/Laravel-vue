<script>
import LoadRow from '@/Components/LoadRow.vue'
import InputText from '@/Components/Inputs/InputText.vue'
import SimpleSelect from '@/Components/Inputs/SimpleSelect.vue'
import InputDate from '@/Components/Inputs/InputDate.vue'

export default {
    data(){
        return {
            client: null,
            readonly: false,
            load: false,
            errors: {}
        }
    },

    created(){
        if(this.$page.props.client_id){
            this.getClient();
        }else{
            this.setData()
        }
    },


    methods: {
        async getClient(){
            this.load = true;
            try {
                var response = await axios.get(`/clientes/findOne/${this.$page.props.client_id}`);
                this.client = response.data
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao buscar cliente', true)
            }
            this.load = false;
        },

        async store(){
            this.readonly = true;
            try {
                let url = '/clientes/'+(this.client.id? 'update' : 'create');
                let method = ( this.client.id? 'put' : 'post' )

                var response = await axios[method](url, this.client);

                if(this.client.id)
                    this.client = response.data.cliente
                else
                    window.location = `/clientes/form/${response.data.cliente.id}`;

                Toast.success(response.data.msg)
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao buscar cliente', true)
            }
            this.readonly = false;
        },



        setData() {
            this.client = {
                nome: null,
                cpf: null,
                data_nasc: null,
                telefone: null,
                ativo: null,
            }
        }
    },


    components: {
        LoadRow,
        InputText,
        SimpleSelect,
        InputDate
    }
}
</script>

<template>
<div class="card">
    <div class="card-body px-5 py-4">
        <form action="#" v-if="!load && client">
            <div class="form-group row mb-0">
                <input-text
                    label="Nome"
                    class="col-md-4"
                    v-model="client.nome"
                    :readonly="readonly"
                    :errors="errors"
                    name="nome"
                    :required="true"/>

                <input-text
                    label="CPF"
                    class="col-md-4"
                    v-model="client.cpf"
                    :readonly="readonly"
                    :errors="errors"
                    name="cpf"
                    :required="true"
                    mask="###.###.###-##"/>

                <input-text
                    label="Telefone"
                    class="col-md-4"
                    v-model="client.telefone"
                    :readonly="readonly"
                    :errors="errors"
                    name="telefone"
                    :required="true"
                    :mask="['(##) ####-####', '(##) #####-####']"/>

                <input-date
                    label="Data Nascimento"
                    v-model="client.data_nasc"
                    :readonly="readonly"/>

                <simple-select
                    label="Ativo"
                    v-model="client.ativo"
                    :readonly="readonly"
                    :options="{
                        1: 'Sim',
                        0: 'Não'
                    }"
                />
            </div>
        </form>

        <load-row v-else/>
    </div>

    <div class="card-body px-5">
        <a class="btn btn-info text-light px-3" href="/clientes" :disabled="readonly">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>
        <button class="btn btn-primary px-3 mx-3" @click="store()" :disabled="readonly">
            <i class="fa-solid fa-floppy-disk"></i>
            Salvar
        </button>
    </div>

</div>
</template>
