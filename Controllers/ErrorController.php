<?php
class ErrorController extends Controller {

    public function __construct() {
        $this->views = new Views();
    }

    public function index($params = []) {
        $this->views->render("error/error404");
    }
}