<?php

namespace Application\Model\ORM;

use Application\Controller\KleoController;
use Application\Model\Entity\Responsavel;
use Exception;

/**
 * Nome: ResponsavelORM.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe com acesso doctrine
 */
class ResponsavelORM extends KleoORM {

    /**
     * Localizar responsavel por token
     * @param String $token
     * @return Responsavel
     * @throws Exception
     */
    public function encontrarPorToken($token) {
        $entidade = null;
        try {
            $entidade = $this->getEntityManager()
                    ->getRepository($this->getEntity())
                    ->findOneBy(array(KleoController::stringToken => $token));
            return $entidade;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function encontrarPorEmail($email) {
        $entidade = null;
        try {
            $entidade = $this->getEntityManager()
                    ->getRepository($this->getEntity())
                    ->findOneBy(array('email' => $email));
            return $entidade;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
