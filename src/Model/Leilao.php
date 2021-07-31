<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;

    private string $descricao;

    private $finalizado;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance)
    {
        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());

        if ($totalLancesUsuario >= 5){
            throw new \DomainException('Usuário não pode dar mais de 5 lances no mesmo leilão');
        }

        if(!empty($this->lances) && $this->verificaSeLanceEDoMesmoUsuarioQueDeuOUltimoLance($lance)) {
            throw new \DomainException('Usuário não pode dar lances seguidos no mesmo leilão');
        }
        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    private function verificaSeLanceEDoMesmoUsuarioQueDeuOUltimoLance(Lance $lance)
    {
        $ultimoLance = $this->lances[count($this->lances) - 1];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    /**
     * @param Usuario $usuario
     * @return int
     */
    private function quantidadeLancesPorUsuario(Usuario $usuario): int
    {
        return $totalLancesUsuario = array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1;
                }

                return $totalAcumulado;
            },
            0
        );
    }

    public function finaliza()
    {
        $this->finalizado = true;
    }

    public function estaFinalizado(): bool
    {
        return $this->finalizado;
    }
}
