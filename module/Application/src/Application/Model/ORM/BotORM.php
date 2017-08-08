<?php

namespace Application\Model\ORM;

use Application\Controller\KleoController;
use Application\Model\Entity\Campanha;
use Exception;

/**
 * Nome: BotORM.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe com acesso doctrine
 */
class BotORM extends KleoORM {

    /**
     * Localizar por $idResponsavel
     * @param String $idResponsavel
     * @return Bot[]
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
      $botsAtivos = null;
      $todasOsBotsPorId = $this->encontrarPorIdResponsavel($idResponsavel);
      foreach($todasOsBotsPorId as $bot){
        if($bot->verificarSeEstaAtivo()){
          $botsAtivos[] = $bot;
        }
      }      
      return $botsAtivos;      
    }
}
