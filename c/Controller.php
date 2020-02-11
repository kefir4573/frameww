<?php
include_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

abstract class Controller
{
    protected $title;
    protected $content;

    protected abstract function render();

    public function Request($action)// инициализация внешнего шаблона
    {
        $this->before();
        $this->$action();
        $this->render();
    }

    protected function before()// инициализация свойств
    {
        $this->title = 'Название сайта';
        $this->content = '';
    }



    protected function TemplatePage($fileName, $mas) // функция шаблонизатора, генерация шаблона
    {
        try {
            $loader = new Twig_Loader_Filesystem('v/templates');

            $twig = new Twig_Environment($loader);

            $template = $twig->loadTemplate($fileName);
            $template = $template->render($mas);
            return $template;


        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}








