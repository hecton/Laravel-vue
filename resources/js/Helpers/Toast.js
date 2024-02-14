import Swal from "sweetalert2"

const Toast = {
    // /**
    //  * Variaveis de trabalho
    //  */
    // apikey: 'AIzaSyC8rgGHqRs9Tqzz7hKOlm3CrAE6-OeXQ4w',
    // msgs: {},

    /**
     * Toast base para mensagens rapidas.
     */
    toast: Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    }),

    /**
     * Menssagem de sucesso.
     * @param mensagem
     */
    success(mensagem){
        this.fire({
            icon: 'success',
            title: mensagem,
        })
    },

    /**
     * Menssagem de atenção.
     * @param mensagem
     */
    warning(mensagem){
        this.fire({
            icon: 'warning',
            title: mensagem,
        })
    },

    /**
     * Menssagem de erro.
     * @param mensagem
     */
    error(mensagem){
        this.fire({
            icon: 'error',
            title: mensagem,
        })
    },

    async fire({title, icon}){
        this.toast.fire({
            icon: icon,
            title: title
        })
    },


    /**
     * monta uma lista de erros baseado no laravel validate.
     * @param erros
     */
    errorLaravel(erros, defualtMsg = 'Erro ao executar', show_error_log = false){
        try{
            if(!erros.response && !(erros instanceof Error)){
                var msg = Object.entries(erros).map(a => a[1]).reduce((a, b) => `${a}\n${b}`);
                this.toast.fire({
                    icon: 'error',
                    title: msg
                });
            }else if(erros.response){
                if(erros.response.status == 422 && erros.response.data.errors)
                    this.errorLaravel(erros.response.data.errors);
                else if(erros.response.data && erros.response.data.msg)
                    this.error(erros.response.data.msg);
                else
                    this.error(defualtMsg);
            }else{
                this.error(defualtMsg);
            }

            if(show_error_log)
                console.error(erros);
        }catch(error){
            console.error('Toast: (Error Laravel)', error);
        }
    },

    /**
     *  Cria um modal de confirmação.
     * @param title
     * @param text
     * @param html
     */
    confirm(title = 'Confimação', text = 'Você confima está ação?', html = ''){
        return Swal.fire({//configurações da confirmação.
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            title: title,
            text: text,
            html: html,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });
    },

    /**
     *
     * @param nome
     * @param texto
     */
    message(nome, texto, foto){
        return this.toast.fire({
            html:
                `<p class="m-0">
                    <img src="${foto? `/assets/img/Users/${foto}` : "/assets/img/cartaoPro/default/comment .png"}" alt="User Image" class="${foto? 'img-circle elevation-2' : ''} mr-2" ${foto? 'width="40" height="40"' : 'width="20" height="20"'}>
                    <span class="swal2-title ml-0 mr-2">${nome.split(' ')[0]}:</span>
                    ${texto.substr(0, 40)+(texto.length > 40? '...' : '')}
                </p>`
        });
    },

    /**
     * Menssagem para dar ok.
     */
    ok(msg, title = 'Oops...', icon = 'error'){
        return Swal.fire({
            icon: icon,
            title: title,
            text: msg,
        })
    }
}

export default Toast;
