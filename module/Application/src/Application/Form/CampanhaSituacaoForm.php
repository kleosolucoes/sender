<?php

namespace Application\Form;

use Zend\Form\Element\Select;
use Application\Model\Entity\Situacao;

/**
 * Nome: CampanhaSituacaoForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario para mudar a situação  
 *              
 */
class CampanhaSituacaoForm extends KleoForm {

    public function __construct($name = null, $id, $todasSituacoes, $idSituacao) {
        parent::__construct($name);

        $inputId = $this->get(self::inputId);
        $inputId->setValue($id);

        $arraySituacoes = [];
        foreach ($todasSituacoes as $situacao) {
            $adicionar = false;
            if ($situacao->getId() === Situacao::agendada) {
                $adicionar = true;
            }
            if ($situacao->getId() === Situacao::recusado) {
                $adicionar = true;
            }
            if ($situacao->getId() === Situacao::emExecucao) {
                $adicionar = true;
            }
            if ($situacao->getId() === Situacao::enviada) {
                $adicionar = true;
            }
            if ($adicionar) {
                $arraySituacoes[$situacao->getId()] = $situacao->getNome();
            }
        }
        $inputSelectSituacoes = new Select();
        $inputSelectSituacoes->setName(self::inputSituacao);
        $inputSelectSituacoes->setAttributes(array(
            self::stringClass => self::stringClassFormControl,
            self::stringId => self::inputSituacao,
            self::stringValue => $idSituacao,
        ));
        $inputSelectSituacoes->setValueOptions($arraySituacoes);
        $this->add($inputSelectSituacoes);
    }

}
