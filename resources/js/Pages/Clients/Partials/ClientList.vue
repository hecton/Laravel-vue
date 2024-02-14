<script>
import LoadRow from '@/Components/LoadRow.vue'

export default {
    data(){
        return {
            clients: null,
            load: false,
            search: null,
            processed_data: [],
        }
    },

    computed: {
        client_list(){
            if(this.search){
                return this.processed_data.filter((i) => {
                    return i.nome.toLowerCase().includes(this.search.toLowerCase());
                })
            }else{
                return this.processed_data;
            }
        }
    },

    created(){
        this.getClients()
    },

    methods: {
        processData(){
            this.processed_data = ([...this.clients]??[])
                .map(i => {
                    let data = moment(i.data_nasc).format('DD/MM/YYYY')
                    i.data_nasc = data

                    return i;
                });
        },

        async getClients(){
            this.load = true;
            try {
                var response = await axios.get('/clientes/getAll');
                this.clients = response.data
                this.processData();
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao buscar clientes', true)
            }
            this.load = false;
        },

        async remove(client){
            var { value } = await Toast.confirm('Remoçao de Cliente', `Deseja remover o cliente "${client.nome}"`);
            if(!value) return;



            this.load = true;
            try {
                await axios.delete(`/clientes/delete/${client.id}`);
                this.getClients();
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao remover cliente', true)
            }
            this.load = false;
        },
    },

    components: {
        LoadRow
    }
}
</script>


<template>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                <a class="btn btn-primary" href="/clientes/form">
                    <i class="fa-solid fa-plus"></i>
                        Adicionar
                </a>
            </div>

            <div class="col-3 offset-7">
                <div class="input-group has-validation">
                    <input type="text" class="form-control" placeholder="pesquisar" v-model="search">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">

            </div>
            <div class="col-12">
                <table class="table table-hover" v-if="!load">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Data de nascimento</th>
                            <th>Telefone</th>
                            <th>Ativo</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="client in client_list" :key="client.id">
                            <td>{{client.nome}}</td>
                            <td>{{client.cpf}}</td>
                            <td>{{client.data_nasc}}</td>
                            <td>{{client.telefone}}</td>
                            <td>
                                <span :class="{
                                    badge: true,
                                    'bg-success': client.ativo,
                                    'bg-warning': !client.ativo,
                                }">
                                    {{client.ativo? 'Sim' : 'Nâo'}}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-danger d-inline btn-sm mx-1" @click="remove(client)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <a class="btn btn-info d-inline btn-sm" :href="`/clientes/form/${client.id}`">
                                    <i class="fa-solid fa-pencil text-light"></i>
                                </a>
                            </td>
                        </tr>
                        <tr v-if="!clients.length">
                            <td colspan="100%">
                                Nenhum item encontrado
                            </td>
                        </tr>
                    </tbody>
                </table>

                <load-row v-else/>
            </div>
        </div>
    </div>
</div>
</template>
