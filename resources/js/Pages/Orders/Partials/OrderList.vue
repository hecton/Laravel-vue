<script>
import LoadRow from '@/Components/LoadRow.vue'
import Filters from '@/Helpers/Filters'

export default {
    data(){
        return {
            orders: null,
            load: false,
            search: null,
            processed_data: []
        }
    },

    computed: {
        order_list(){
            if(this.search){
                return this.processed_data.filter((i) => {
                    return i.produto.toLowerCase().includes(this.search.toLowerCase());
                })
            }else{
                return this.processed_data;
            }
        }
    },

    created(){
        this.getOrders()
    },

    methods: {
        processData(){
            this.processed_data = ([...this.orders]??[])
                .map(i => {
                    i.data = Filters.date(i.data)
                    i.valor = Filters.brl_(i.valor)

                    return i;
                });
        },

        async getOrders(){
            this.load = true;
            try {
                var response = await axios.get('/pedidos/getAll');
                this.orders = response.data
                this.processData()
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao buscar pedidos', true)
            }
            this.load = false;
        },

        async remove(order){
            var { value } = await Toast.confirm('Remoçao de Pedido', `Deseja remover o pedido de "${order.produto}" feito por "${order.cliente.nome}"`);
            if(!value) return;



            this.load = true;
            try {
                await axios.delete(`/pedidos/delete/${order.id}`);
                this.getOrders();
            }catch(err){
                Toast.errorLaravel(err, 'Erro ao remover pedido', true)
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
            <div class="col-6">
                <a class="btn btn-primary" href="/pedidos/form">
                    <i class="fa-solid fa-plus"></i>
                        Adicionar
                </a>

                <a class="btn btn-success mx-2" href="/pedidos/export-excel" target="_blank">
                    <i class="fa-solid fa-file-excel"></i>

                    Excel
                </a>
            </div>
            <div class="col-3 offset-3">
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
                            <th>Produto</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ativo</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="order in order_list" :key="order.id">
                            <td>{{order.produto}}</td>
                            <td>{{order.cliente.nome}}</td>
                            <td>{{order.data}}</td>
                            <td>{{order.pedido_status.description}}</td>
                            <td>
                                <span :class="{
                                    badge: true,
                                    'bg-success': order.ativo,
                                    'bg-warning': !order.ativo,
                                }">
                                    {{order.ativo? 'Sim' : 'Nâo'}}
                                </span>
                            </td>
                            <td>{{ order.valor }}</td>
                            <td>
                                <button class="btn btn-danger d-inline btn-sm mx-1" @click="remove(order)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <a class="btn btn-info d-inline btn-sm" :href="`/pedidos/form/${order.id}`">
                                    <i class="fa-solid fa-pencil text-light"></i>
                                </a>
                            </td>
                        </tr>
                        <tr v-if="!orders.length">
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
