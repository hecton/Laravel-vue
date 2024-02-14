<script>
import LoadRow from '@/Components/LoadRow.vue'
import InputText from '@/Components/Inputs/InputText.vue'
import SimpleSelect from '@/Components/Inputs/SimpleSelect.vue'
import InputDate from '@/Components/Inputs/InputDate.vue'
import InputMoney from '@/Components/Inputs/InputMoney.vue'
import SelectStatusPedido from '@/Components/Inputs/SelectStatusPedido.vue'
import InputImagemVue from '@/Components/Inputs/InputImageVue.vue'
import SearchClient from '@/Components/Inputs/SearchClient.vue'
import axios from 'axios'

export default {
    data(){
        return {
            pedido: null,
            readonly: false,
            load: false,
            errors: {}
        }
    },

    created(){
        if(this.$page.props.order_id){
            this.getPedido();
        }else{
            this.setData()
        }
    },


    methods: {
        async getPedido(){
            this.load = true;
            try {
                var response = await axios.get(`/pedidos/findOne/${this.$page.props.order_id}`);
                this.pedido = response.data
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao buscar pedido', true)
            }
            this.load = false;
        },

        async store(){
            this.readonly = true;
            try {
                let form_data = this.setFormData()
                let url = '/pedidos/'+(this.pedido.id? 'update' : 'create');

                var response = await axios({
                    method: 'post',
                    url,
                    data: form_data,
                    headers: { "Content-Type": `multipart/form-data`}
                });

                if(this.pedido.id){
                    this.pedido = response.data.pedido
                }else{
                    window.location = `/pedidos/form/${response.data.pedido.id}`
                }
                Toast.success(response.data.msg)
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao buscar pedido', true)
            }
            this.readonly = false;
        },

        setFormData(){
            let formData = new FormData;
            Object.entries(this.pedido).forEach(([key, value]) => {
                if(key == 'imagem'){
                    value.forEach(img => {
                        if(img.file){
                            formData.append('uploaded_images[]', img.file)
                        }else{
                            formData.append('imagem[]', img.id)
                        }
                    })
                }else{
                    formData.append(key, value??'')
                }
            })

            return formData;
        },



        setData() {
            this.pedido = {
                produto: null,
                valor: '0',
                data: null,
                cliente_id: null,
                pedido_status_id: null,
                ativo: null,
            }
        }
    },


    components: {
        LoadRow,
        InputText,
        SimpleSelect,
        InputDate,
        InputMoney,
        SelectStatusPedido,
        SearchClient,
        'input-imagem-vue': InputImagemVue,
    }
}
</script>

<template>
<div class="card">
    <div class="card-body px-5 py-4">
        <form action="#" v-if="!load && pedido">
            <div class="form-group row mb-0">
                <input-text
                    label="Produto"
                    class="col-md-4"
                    v-model="pedido.produto"
                    :readonly="readonly"
                    :errors="errors"
                    name="produto"
                    :required="true"/>

                <input-money
                    label="Valor"
                    class="col-md-4"
                    v-model="pedido.valor"
                    :readonly="readonly"
                    :errors="errors"
                    :required="true"/>


                <input-date
                    class="col-md-4"
                    label="Data"
                    v-model="pedido.data"
                    :readonly="readonly"/>

                <simple-select
                    class="col-md-4"
                    label="Ativo"
                    v-model="pedido.ativo"
                    :readonly="readonly"
                    :options="{
                        1: 'Sim',
                        0: 'Não'
                    }"/>

                <select-status-pedido
                    class="col-md-4"
                    v-model="pedido.pedido_status_id"
                    label="Status do Pedido"
                    :readonly="readonly"/>

                <search-client
                    class="col-md-4"
                    v-model="pedido.cliente_id"
                    label="Cliente"
                    :readonly="readonly"/>


                <input-imagem-vue
                    :readonly="readonly"
                    v-model="pedido.imagem"
                />
            </div>
        </form>

        <load-row v-else/>
    </div>

    <div class="card-body px-5">
        <a class="btn btn-info text-light mx-2 px-3" href="/pedidos" :disabled="readonly">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>
        <button class="btn btn-primary px-3" @click="store()" :disabled="readonly">
            <i class="fa-solid fa-floppy-disk"></i>
            Salvar
        </button>
    </div>

</div>
</template>
