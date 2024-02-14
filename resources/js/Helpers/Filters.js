import { filter } from "lodash"

const filters = {
    date: (date) =>  {
        let date_string = moment(date).format('DD/MM/YYYY')
        return date_string == 'Invalid date'? '-' : date_string;
    },

    month_year: (date) =>  {
        let date_string = moment(date).format('YYYY/MM')
        return date_string == 'Invalid date'? '-' : date_string;
    },

    datetime(datetime){
        let date_string = moment(datetime).format('DD/MM/YYYY HH:mm:ss')
        return date_string == 'Invalid date'? '-' : date_string;
    },

    brl: (value) => {
        var number = Number(value)
        number = !!number? number : 0

        return new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(number)
    },

    brl_: (value) => {
        if(!value) return '-';
        return filters.brl(value);
    },

    adress: (adress) => {
        try {
            if(!adress) return '';
            var text = `${adress.street??''}`
            if(adress.number) text += `, ${adress.number}`
            if(adress.complement) text += ` - ${adress.complement}`
            if(adress.neighborhood) text += ` - ${adress.neighborhood}`
            if(adress.municipio) {
                text += ` - ${adress.municipio.mun_nome}`
                if(adress.municipio.estado) text += `/${adress.municipio.estado.est_sigla}`
            }
            return text||'-';
        }catch(err){
            console.error(err)
            return value
        }
    },

    censure: (value, num, word = false, word_break = ' ') => {
        var repeat = (num, caracter) => {
            var text = ''
            for(let i =0; i < num; i++){ text+=caracter }
            return text
        }

        try {
            if(word){
                let splited = value.split(word_break)
                let unsensured = splited.slice(0, num).join(' ')
                let sensured = splited.slice(num).map(w => repeat(w.length, '*')).join('*')
                return unsensured+' '+sensured
            }else {
                return value.slice(0, num)+repeat(value.slice(num).length, '*')
            }
        }catch(err){
            return value
        }
    },
    payment_way(way){
        var ways  = {
            'BOLETO': 'Boleto',
            'CREDIT_CARD': 'Cartão de crédito',
            'PIX': 'PIX',
            'DINHEIRO': 'Dinheiro',
            'TRANSFERENCIA': 'Transfêrencia',
            'OUTROS': 'Outros',
        };
        return ways[way]??'Outros'
    },

    long_time(time){
        if(!time || !/([0-9]{2}(:?)){3}/.test(time)) return '-'
        var time_split = time.split(':')
        var h = Number(time_split[0])
        var m = Number(time_split[1])
        var s = Number(time_split[2])

        return `${h? h+'h ':''}${m? m+'m ':''}${s? s+'s ':''}`
    },

    name(name){
        try {
            if(!name) return '-'
            return name.split(' ').map(n => n[0].toUpperCase()+n.slice(1).toLowerCase()).join(' ');
        }catch(err){
            return name
        }
    },

    short_adress(adress){
        if(!adress)
            return '-'
        else
            return (adress.neighborhood? adress.neighborhood+' | ' : '')+adress.municipio?.mun_nome
    },

    getFilters(...filters){
        if(filters.some(f => typeof f != 'string')) throw new Error('Invalid argument type, Only strings are allowed');
        var data = {}
        filters.forEach(f => {
            data[f] = this[f]
        });
        return data;
    },

    short_name(name){
        let splited = name.split(' ');
        return splited[0]+' '+splited[1].slice(0, 2);
    },

    full_month(month){
        return {
            1:'Janeiro',
            2:'Fevereiro',
            3:'Março',
            4:'Abril',
            5:'Maio',
            6:'Junho',
            7:'Julho',
            8:'Agosto',
            9:'Setembro',
            10:'Outubro',
            11:'Novembro',
            12:'Dezembro'
        }[month]??null
    },

    porcent(value){
        var number = Number(value)
        number = !!number? number : 0

        return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(number)+' %'
    }
}

export default filters
