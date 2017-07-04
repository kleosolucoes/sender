<?php

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Number;
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
                        ->setName(self::inputTitulo)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputTitulo,
                            self::stringRequired => self::stringRequired,
                            self::stringPlaceholder => 'Ex: Blusa Lacoste Branca Masculina',
                        ])
        );

        $this->add(
                (new TextArea())
                        ->setName(self::inputDescricao)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputDescricao,
                            self::stringRequired => self::stringRequired,
                        ])
        );

        $this->add(
                (new File())
                        ->setName(self::inputFoto)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputFoto,
                            self::stringRequired => self::stringRequired,
                            'onchange' => 'carregarFoto(this, 1);',
                        ])
        );

    }

}
