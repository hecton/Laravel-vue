<script>
export default {
    data(){
        return {
            pathname: null,
            options: [
                {
                    url: '/clientes',
                    icon: "fa-solid fa-person",
                    title: 'Clientes'
                },{
                    url: '/clientes/form',
                    icon: "fa-solid fa-plus",
                    title: 'Cadastrar Cliente'
                },{
                    url: '/pedidos',
                    icon: "fa-solid fa-list",
                    title: 'Pedidos'
                },{
                    url: '/pedidos/form',
                    icon: "fa-solid fa-plus",
                    title: 'Cadastrar Pedido'
                },
            ]
        }
    },

    created(){
        this.pathname = window.location.pathname;
    }
}
</script>

<template>
<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand px-4" href="#">
        <b class="text-light">
            <i class="fa-brands fa-first-order-alt"></i>
            Pedidos.Vue
        </b>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item" v-for="(option, key) in options" :key="key">
            <a :class="{
                'nav-link btn btn-primary btn-sm text-light px-3 mx-1': true,
                'active': pathname == option.url
            }" :href="option.url">
                <!-- <i :class="option.icon"></i> -->
                {{ option.title }}
            </a>
          </li>
      </ul>
    </div>
  </div>
</nav>
</template>
