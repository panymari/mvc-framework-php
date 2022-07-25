<?php

class Application {

    // method to start autoload
    public function run(){
        $this->Loader();
    }

    // method for load logic
    public function Loader(){
        spl_autoload_register(['ClassLoader', 'autoload'], true, true);
    }

}