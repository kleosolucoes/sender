<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Application\Controller\KleoController;

/**
 * Nome: Menu.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para mostrar o menu
 */
class Menu extends AbstractHelper {

    public function __construct() {
        
    }

    public function __invoke() {
        return $this->renderHtml();
    }

    public function renderHtml() {
        $html = '';

        $stringFoto = 'placeholder.png';

        // Start: Header 
        $html .= '<header class="navbar navbar-fixed-top">';

        $html .= '<div class="navbar-branding">';
        $html .= '<a class="navbar-brand" href="#" style="padding-top: 22px;">';
        $html .= '<img src="/img/site/logonova2.png" title="';
        $html .= $this->view->translate(KleoController::nomeAplicacao);
        $html .= '" class="img-responsive" style="max-width:100%;">';
        $html .= '</a>';
        $html .= '<span id="toggle_sidemenu_l" class="ad ad-lines"></span>';
        $html .= '</div>';
        $html .= '<ul class="nav navbar-nav navbar-right">';
        $html .= '<li class="dropdown menu-merge">';
        $html .= '<a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">';
        $html .= $this->view->responsavel->getNomeEmpresa();
        $html .= '<span class="pl5">- ' . $this->view->responsavel->getNome() . '</span>';
        $html .= '<span class="caret caret-tp"></span>';
        $html .= '</a>';

        $html .= '<ul class="dropdown-menu list-group dropdown-persist w250" role="menu">';
        $html .= '<li class="dropdown-footer">';
        $html .= '<a href="/admsair">';
        $html .= '<span class="fa fa-power-off pr5"></span>' . 'Sair' . '</a>';
        $html .= '</li>';
        $html .= '</ul>';
        $html .= '</li>';
        $html .= '</ul>';

        $html .= '</header>';

        // Start: Sidebar
        $html .= '<aside id="sidebar_left" class="nano nano-light affix">';

        // Start: Sidebar Left Content
        $html .= '<div class="sidebar-left-content nano-content">';

        // Start: Sidebar Header
        $html .= '<header class="sidebar-header">';

        // Sidebar Widget - Author 
        $html .= '<div class="sidebar-widget author-widget">';
        $html .= '<div class="media">';
        $html .= '<div class="media-body">';
        $html .= '<div class="media-links">';
        $html .= '<a href="/admsair">Sair</a>';
        $html .= '</div>';
        $html .= '<div class="media-author">' . $this->view->responsavel->getNome() . '</div>';
        $html .= '<div class="media-author">' . number_format($this->view->responsavel->getSaldo(), 0, '.', '.') . ' Créditos' . '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '</header>';

        $html .= '<ul class="nav sidebar-menu">';

        $html .= '<li class="sidebar-label pt20">Principal</li>';
        $html .= '<li>';
        $html .= '<a href="/admCampanhas">';
        $html .= '<span class="fa fa-home"></span>';
        $html .= '<span class="sidebar-title">Principal</span>';
        $html .= '</a>';
        $html .= '</li>';

        /* Start: Sidebar Menu */
        $html .= '<ul class="nav sidebar-menu">';
        $html .= '<li class="sidebar-label pt20">Menu</li>';

        if ($this->view->responsavel->getId() === KleoController::idResponsavelAdmin) {
            $html .= '<li>';
            $html .= '<a href="/admResponsaveis">';
            $html .= '<span class="fa fa-users"></span>';
            $html .= '<span class="sidebar-title">Responsaveis</span>';
            $html .= '</a>';
            $html .= '</li>';
        }

        $html .= '<li>';
        $html .= '<a href="/admCampanhas">';
        $html .= '<span class="fa fa-paper-plane"></span>';
        $html .= '<span class="sidebar-title">Campanhas</span>';
        $html .= '</a>';
        $html .= '</li>';

        $html .= '<li>';
        $html .= '<a href="/admListas">';
        $html .= '<span class="fa fa-users"></span>';
        $html .= '<span class="sidebar-title">Contatos</span>';
        $html .= '</a>';
        $html .= '</li>';

        if ($this->view->responsavel->getId() !== KleoController::idResponsavelAdmin) {
            $html .= '<li>';
            $html .= '<a href="/admCredito">';
            $html .= '<span class="fa fa-money"></span>';
            $html .= '<span class="sidebar-title">Comprar Crédito</span>';
            $html .= '</a>';
            $html .= '</li>';
        }

        if ($this->view->responsavel->getId() === KleoController::idResponsavelAdmin) {
            $html .= '<li>';
            $html .= '<a href="/admContaCorrente">';
            $html .= '<span class="fa fa-money"></span>';
            $html .= '<span class="sidebar-title">Conta-Corrente</span>';
            $html .= '</a>';
            $html .= '</li>';
        }

        $html .= '</ul>';
        // End: Sidebar Menu
        // Start: Sidebar Collapse Button
        $html .= '<div class="sidebar-toggle-mini">';
        $html .= '<a href="/admsair">';
        $html .= '<span class="fa fa-sign-out"></span>';
        $html .= '</a>';
        $html .= '</div>';
        // End: Sidebar Collapse Button

        $html .= '</div>';
        // End: Sidebar Left Content

        $html .= '</aside>';

        return $html;
    }

}
