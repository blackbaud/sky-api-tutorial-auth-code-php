<?php

class View{

    public function __construct($viewLoader){
        $this->viewLoader = $viewLoader;
    }

    public function display($viewName){
        echo $this->viewLoader->load($viewName);
    }
}