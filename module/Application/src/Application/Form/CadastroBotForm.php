<?php

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;

/**
 * Nome: CadastroBotForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de cadastro de bot
 *              
 */
class CadastroBotForm extends KleoForm {

    public function __construct($name = null) {
        parent::__construct($name);

        $this->add(
                (new Textarea())
                        ->setName(self::inputMensagem)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputMensagem,
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );

        $this->add(
                (new Text())
                        ->setName(self::inputTitulo . '1')
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputTitulo . '1',
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );

        $this->add(
                (new Textarea())
                        ->setName(self::inputResposta . '1')
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputResposta . '1',
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );


        $this->add(
                (new Text())
                        ->setName(self::inputTitulo . '2')
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputTitulo . '2',
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );

        $this->add(
                (new Textarea())
                        ->setName(self::inputResposta . '2')
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputResposta . '2',
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );


        $this->add(
                (new Text())
                        ->setName(self::inputTitulo . '3')
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputTitulo . '3',
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );

        $this->add(
                (new Textarea())
                        ->setName(self::inputResposta . '3')
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputResposta . '3',
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );
    }

}
