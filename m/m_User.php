<?php

class m_User
{
    public function getUser($login, $pas)
    {//создаем сессию и записываем данные пользователя
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['pas'] = $pas;
        $this->refresh('?act=lk&c=users');
    }

    public function getTextUserLk()
    {//получаем логин и выводим текст
        $login = $_SESSION['login'];
        $text = 'Добро пожаловать: ' . $login;
        return $text;
    }

    public function outUserLk()
    {//удаляем сессию, переходим на страницу авторизации
        session_destroy();
        $this->refresh('?c=users');
    }

    public function refresh($url)
    {// редирект
        echo '<meta http-equiv="refresh" content="0; url=' . $url . '">';

    }
}
