<?php

namespace Mg\Imoispm\Utility;

use Mg\Imoispm\Domain\Repository\ImoChiffreRepository as RepositoryImoChiffreRepository;

class ChiffreGenerator
{
    /**
     * @var ImoChiffreRepository
     */
    protected $imoChiffreRepository;

    /**
     * Constructor
     *
     * @param ImoChiffreRepository $imoChiffreRepository
     */
    public function __construct(RepositoryImoChiffreRepository $imoChiffreRepository)
    {
        $this->imoChiffreRepository = $imoChiffreRepository;
    }

    /**
     * Generate Unique Chiffre
     *
     * @param int $length
     * @return string
     */
    public function generateChiffre(int $length = 6): string
    {
        do {
            $chiffre = $this->generate($length);
            $existingChiffre = $this->imoChiffreRepository->findOneByChiffre($chiffre);
        } while ($existingChiffre !== null);

        return $chiffre;
    }

    /**
     * Generate Random Chiffre
     *
     * @param int $length
     * @return string
     */
    protected function generate(int $length): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCharacter = $characters[rand(0, $charactersLength - 1)];
            $randomString .= $randomCharacter;
        }

        return $randomString;
    }
}
