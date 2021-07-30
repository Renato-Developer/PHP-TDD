<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores)
    {
        self::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $indice => $valorEsperado) {
            self::assertEquals($valorEsperado, $leilao->getLances()[$indice]->getValor());
        }
    }

    public function geraLances()
    {
        $joao = new Usuario("João");
        $maria = new Usuario('Maria');

        $leilaoCom2Lances = new Leilao('F1000');
        $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

        $leilaoCom1Lance = new Leilao('F1100');
        $leilaoCom1Lance->recebeLance(new Lance($joao, 5000));

        return [
            'Leilão com 1 Lance' => [1, $leilaoCom1Lance, [5000]],
            'Leilão com 2 Lances' => [2, $leilaoCom2Lances, [1000,2000]]
        ];
    }
}