<?php

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Date;
use Zend\Form\Element\File;
use Zend\Form\Element\Select;

/**
 * Nome: CadastroAnuncioForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de cadastro de anuncios
 *              
 */
class CadastroCampanhaForm extends KleoForm {

    public function __construct($name = null, $listas = null) {
        parent::__construct($name);

        $this->add(
                (new Text())
                        ->setName(self::inputNome)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputNome,
                            self::stringRequired => self::stringRequired,
                        ])
        );

        $this->add(
                (new Text())
                        ->setName(self::inputDataEnvio)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputDataEnvio,
                            self::stringRequired => self::stringRequired,
                        ])
        );

        $this->add(
                (new File())
                        ->setName(self::inputFotoPerfil)
                        ->setAttributes([
                            self::stringClass => self::stringClassGuiFile,
                            self::stringId => self::inputFotoPerfil,
                            self::onChange => 'carregarFoto(this, 1); document.getElementById(\'text_' . self::inputFotoPerfil . '\').value = this.value;',
                        ])
        );

        $this->add(
                (new File())
                        ->setName(self::inputUpload)
                        ->setAttributes([
                            self::stringClass => self::stringClassGuiFile,
                            self::stringId => self::inputUpload,
                            self::onChange => 'carregarFoto(this, 2); document.getElementById(\'text_' . self::inputUpload . '\').value = this.value;',
                        ])
        );

        $this->add(
                (new TextArea())
                        ->setName(self::inputMensagem)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputMensagem,
                        ])
        );

        $inputSelectLista = new Select();
        $inputSelectLista->setName(self::inputListaId);
        $inputSelectLista->setAttributes(array(
            self::stringClass => self::stringClassFormControl,
            self::stringId => self::inputListaId,
            self::stringRequired => self::stringRequired,
        ));
        $inputSelectLista->setEmptyOption(self::traducaoSelecione);
        $this->add($inputSelectLista);
        $this->setarListas($listas);
    }

    public function setarListas($listas) {
        $arrayListas = [];
        if ($listas) {
            foreach ($listas as $lista) {
                $arrayListas[$lista->getId()] = $lista->getNome() . ' - ' . count($lista->getContatoAtivos()) . ' Números';
            }
        }
        $inpuLista = $this->get(self::inputListaId);
        $inpuLista->setValueOptions($arrayListas);
    }

}
