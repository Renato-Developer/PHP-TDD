<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveAceitarMaisDe5LancesDoMesmoUsuario()
    {
        $joao = new Usuario("João");
        $maria = new Usuario("Maria");

        $leilao = new Leilao('F1000');
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 6000));
        $leilao->recebeLance(new Lance($joao, 7000));
        $leilao->recebeLance(new Lance($maria, 8000));
        $leilao->recebeLance(new Lance($joao, 9000));
        $leilao->recebeLance(new Lance($maria, 10000));

        $leilao->recebeLance(new Lance($joao, 11000));

        self::assertCount(10, $leilao->getLances());
        self::assertEquals(10000, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    public function testLeilaoNaoDeveAceitarLancesSeguidosDoMesmoUsuario()
    {
        $joao = new Usuario("João");

        $leilao = new Leilao('F1000');
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($joao, 2000));

        self::assertCount(1, $leilao->getLances());
        self::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

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