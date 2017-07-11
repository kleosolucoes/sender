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

    public function __construct($name = null) {
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
                (new Date())
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
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputFotoPerfil,
                            self::stringRequired => self::stringRequired,
                            self::onChange => 'carregarFoto(this, 1);',
                        ])
        );
      
      $this->add(
                (new File())
                        ->setName(self::inputUpload)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputUpload,
                            self::stringRequired => self::stringRequired,
                            self::onChange => 'carregarFoto(this, 2);',
                        ])
        );
      
        $this->add(
                (new TextArea())
                        ->setName(self::inputMensagem)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputMensagem,
                            self::stringRequired => self::stringRequired,
                        ])
        );

    }

}
