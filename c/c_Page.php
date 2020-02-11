<?php


class c_Page extends Controller
{
    public function action_index()
    {
        $this->title = 'Главная страница2';
        $text = 'НОВЫЙ ТЕКСТ';
        $this->content = $this->TemplatePage('v_index.tmpl',array('text' => $text));

    }

    public function render(){
        $vars = array('title' => $this->title, 'content' => $this->content);
        $page = $this->TemplatePage('main.tmpl', $vars);
        echo $page;
    }

}