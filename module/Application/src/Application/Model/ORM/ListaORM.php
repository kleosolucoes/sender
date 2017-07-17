<?php

namespace Application\Model\ORM;

use Application\Controller\KleoController;
use Application\Model\Entity\Campanha;
use Exception;

/**
 * Nome: ListaORM.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe com acesso doctrine
 */
class ListaORM extends KleoORM {

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
      $listasAtivas = null;
      $todasAsListasPorId = $this->encontrarPorIdResponsavel($idResponsavel);
      foreach($todasAsListasPorId as $lista){
        if($lista->verificarSeEstaAtivo()){
          $listasAtivas[] = $lista;
        }
      }      
      return $listasAtivas;      
    }
}
