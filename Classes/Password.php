<?php
require_once "Element.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Password
 *
 * @author Arttu Lehtovaara
 */
class Password extends Element
{
    public function __construct($name, $value="")
    {
        parent::__construct("input", $name, $value);
        
        $this->addAttribute("type", "password");
    }
}

