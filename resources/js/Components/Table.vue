<script>
export default {
    props: {
        head: {
            type: Array,
            required: true
        },
        body: {
            type: Array,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        control: {
            type: Array,
        }
    },

    data(){
        return {
            data: null,
            load: false,
            search: false
        }
    },

    computed: {
        list(){
            var body = body.map(i => i.split('.'));
            var search = this.search.match(RegExp(search.toLocaleLowerCase()))

            return this.data
                .map((tr, key) => {
                    return {
                        __table_id: key,
                        data: body.map((item) => {
                            return item.reduce((obj, index) => index in obj? obj[index] : obj, tr)
                        }),
                    }
                })
                // .filter(tr => {
                //     let text = JSON.stringify(tr).toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "")
                //     return text.match(search);
                // })
        }
    },

    watch: {
        url: {
            handdler(){
                this.getData()
            },
            immediate: true
        }
    },

    methods: {
        async getData(){
            this.load = true;
            try {
                var response = await axios.get('/clientes/getAll');
                this.clients = response.data
            }catch(err){
                console.log(err)
            }
            this.load = false;
        }
    },
}
</script>

<template>
<div class="row">
        <div class="col-12">
            <!-- <div class="form-group">
                <div class="input-control">

                </div>
            </div> -->
        </div>
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th v-for="(th, key) in head" :key="key">{{ th }}</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="{ tr } in list" :key="tr.__table_id" >
                        <td v-for="(td, td_key) in tr.data" :key="td_key">
                            {{ td }}
                        </td>

                        <td v-if="control.length">
                            <button
                                class="btn btn-danger d-inline btn-sm mx-1"
                                v-if="control.includes('remove')"
                                @click="$emit('remove', data[tr.__table_id])">

                                Remover
                            </button>

                            <button
                                class="btn btn-info d-inline btn-sm"
                                v-if="control.includes('edit')"
                                @click="$emit('edit', data[tr.__table_id])">


                                Editar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
