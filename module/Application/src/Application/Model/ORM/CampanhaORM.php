<?php

namespace Application\Model\ORM;

use Application\Controller\KleoController;
use Application\Model\Entity\Campanha;
use Exception;

/**
 * Nome: CampanhaORM.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe com acesso doctrine
 */
class CampanhaORM extends KleoORM {

    /**
     * Localizar responsavel por token
     * @param String $token
     * @return Campanha[]
     * @throws Exception
     */
    public function encontrarPorIdResponsavel($idResponsavel) {
        $entidade = null;
        try {
            $entidade = $this->getEntityManager()
                    ->getRepository($this->getEntity())
                    ->findBy(array(KleoController::stringIdResponsavel => $idResponsavel));
            return $entidade;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function encontrarPorIdResponsavelEAtivos($idResponsavel) {
      $campanhasAtivas = null;
      $todasAsCampanhasPorId = $this->encontrarPorIdResponsavel($idResponsavel);
      foreach($todasAsCampanhasPorId as $campanha){
        if($campanha->verificarSeEstaAtivo()){
          $campanhasAtivas[] = $campanha;
        }
      }      
      return $campanhasAtivas;      
    }

}
