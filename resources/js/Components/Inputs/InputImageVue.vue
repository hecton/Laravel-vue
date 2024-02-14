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
        modelValue: Array,
    },

    methods: {
        setFile(e){
            var extensios = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'];
            var file = e.target.files[0];
            e.target.value = null;
            var extension = file.name.split('.').pop();

            if(!extensios.includes(extension)) {
                Toast.error('extensão não suportada, Extensões suportadas '+extensios.join(', '))
                return false;
            }

            var imagens = this.modelValue??[];
            var currentUrl = window.URL.createObjectURL(file);


            imagens.push({
                file,
                currentUrl
            })

            this.$emit('update:modelValue', imagens)
        },

        async removeFile(key){
            var img = this.modelValue[key];
            var img_url = img.id? `/img/pedido/imagens/${img.capa}` : img.currentUrl

            //Confirmação do usuário.
            var {value} = await Toast.confirm('Deseja excluír a foto?', '', `<img src="${img_url}" style="max-height: 110px;">`);
            if(value){
                var value = [...this.modelValue];
                value.splice(key, 1);
                this.$emit('update:modelValue', value);
            }
        }
    }
}

</script>


<template>
    <div class="row __input_imagem_vue">
        <div class="col-12 __input_imagem_vue_body">

            <div class="__show_img_input_imagem" v-for="(img, key) in modelValue" :key="key">
                <span class="text-danger">Remover</span>

                <img
                    :src="img.id? `/img/pedido/imagens/${img.capa}` : img.currentUrl"
                    class="img-thumbnail"
                    @click="removeFile(key)">
            </div>



            <label class="add_image btn btn-primary" for="__input_file_vue">
                <span>
                    <i class="fa-solid fa-plus"></i>
                    Adicionar Imagem
                </span>
            </label>

            <input type="file" class="d-none" id="__input_file_vue" @change="setFile">
        </div>
    </div>
</template>
