<?php

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\File;

/**
 * Nome: CadastroListaForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de cadasro de lista de cotato
 *              
 */
class CadastroListaForm extends KleoForm {

    public function __construct($name = null) {
        parent::__construct($name);

        $this->add(
                (new Text())
                        ->setName(self::inputNome)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputNome,
                            self::stringRequired => self::stringRequired,
                            self::stringOnblur => self::stringValidacoesFormulario,
                        ])
        );

        $this->add(
                (new Text())
                        ->setName(self::inputDescricao)
                        ->setAttributes([
                            self::stringClass => self::stringClassFormControl,
                            self::stringId => self::inputDescricao,
                        ])
        );

        $this->add(
                (new File())
                        ->setName(self::inputUpload)
                        ->setAttributes([
                            self::stringClass => self::stringClassGuiFile,
                            self::stringId => self::inputUpload,
                            self::stringRequired => self::stringRequired,
                            self::onChange => 'validarSeEArquivoCSV(this); document.getElementById(\'text_'.self::inputUpload.'\').value = this.value;',
                        ])
        );
    }

}
