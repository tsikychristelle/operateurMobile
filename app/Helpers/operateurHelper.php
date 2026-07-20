<?php

if (!function_exists('getOperateurByNumero')) {
    
    function getOperateurByNumero($numero)
    {
        $model = new \App\Models\OperateurPrefixModel();
        
        $prefix = substr($numero, 0, 3);   
        
        return $model
            ->join('operateur', 'operateur.id = operateurPrefix.idOperateur')
            ->where('prefix', $prefix)
            ->first();
    }
}