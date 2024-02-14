<?php

namespace App\Helpers;

class Document
{
    /**
     * check if cpf is valid
     *
     * @param  string $cpf
     * @return bool
     */
    public static function cpfIsValid(string $value): bool
    {
        $strCpf = str_replace(['.', '-'], '', $value);
        if(!preg_match('/^([0-9]{3}\.){2}([0-9]{3}\-)([0-9]{2})$/', $value) || preg_match('/\b([0-9])\1+\b/', $strCpf))
            return false;

        for($dif = 0; $dif < 2; $dif++){
            $soma = 0;
            for($i = 0; $i < (9+$dif); $i++)
                $soma += $strCpf[$i] * ((10+$dif) - $i);
            // calcula o resto
            $resto = ($soma*10) % 11;
            if($resto == 10 || $resto == 11) $resto = 0;
            // verifca se o resto é igual ao digito verificador
            if($resto != $strCpf[9+$dif]) return false;
        }

        return true;
    }
}
