<?php

class Controller {

    protected $views, $model;

    public function __construct() {
        $this->views = new Views(); // Listo para renderizar
        $this->loadModel(); // busca un modelo cuyo nombre coincida 
    }

    public function loadModel() {
        $modelName = str_replace("Controller", "Model", get_class($this)); 
        $modelPath = "Models/{$modelName}.php"; 
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName(); // Instancia un nuevo objeto modelo 
        }
    }
}