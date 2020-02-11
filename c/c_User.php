<?php

include_once "m/m_User.php";

class c_User extends Controller
{
    const MAIN_TMPL = 'main.tmpl';
    private $mUser;//главный шаблон

    public function __construct()
    {
        $this->mUser = $this->modelUser();
    }

    public function modelUser()
    {
        return new m_User();
    }

    public function action_index()// страницы входа
    {
        $this->title = 'Страница входа';
        $text = 'Введите логин и пароль';
        $this->content = $this->TemplatePage('v_auth.tmpl', array('text' => $text));
        if (isset($_POST['inUserB'])) {
            $login = $_POST['login'];
            $pas = $_POST['pas'];
            $this->mUser->getUser($login, $pas);

        }

    }

    public function action_lk()// страница личного кабинета
    {
        session_start();
        if (empty($_SESSION['login'])) {// если логин или пароль пустой, то делаем редирект на авторизацию
            $this->mUser->refresh('?c=users');
        } else {
            $this->title = 'Личный кабинет';
            $text = $this->mUser->getTextUserLk();
            $this->content = $this->TemplatePage('v_lk.tmpl', array('title' => $this->title, 'text' => $text));
            if (isset($_POST['outUserB'])) {
                $this->mUser->refresh('?act=out&c=users');// редирект на страницу выхода
            }
        }

    }

    public function action_out()// страница выхода
    {
        session_start();
        $this->mUser->outUserLk();
    }

    public function render()
    {// генерация внешнего шаблона
        $vars = array('title' => $this->title, 'content' => $this->content);
        $page = $this->TemplatePage(self::MAIN_TMPL, $vars);
        echo $page;
    }
}