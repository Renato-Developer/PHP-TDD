<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require "vendor/autoload.php";

// Arrumo a casa para o teste - ARRANGE || GIVEN (Martin Fowler)
$leilao = new Leilao('Camaro');

$renato = new Usuario('Renato');
$agatha = new Usuario('Agatha');

$leilao->recebeLance(new Lance($renato, 1000));
$leilao->recebeLance(new Lance($agatha, 2000));

// Executo o código a ser testado - ACT || WHEN (Martin Fowler)
$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);
$maiorValor = $leiloeiro->getMaiorValor();

$valorEsperado = 2000;

// Verifico a saída esperada - ASSERT || THEN (Martin Fowler)
if ($maiorValor != $valorEsperado) {
    echo "Teste FALHOU";
    exit();
}
echo "Teste OK";
