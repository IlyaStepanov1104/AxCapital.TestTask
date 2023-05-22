<?php

abstract class Page
{
    public $user;
    public $pdo;

    public function __construct($user, $pdo)
    {
        $this->user = $user;
        $this->pdo = $pdo;
    }

    public function head()
    {
        echo "<!doctype html>";
        echo "<html lang=\"en\">";
        echo "<head>";
        echo "<meta charset=\"UTF-8\">";
        echo "<meta name=\"viewport\"";
        echo "content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">";
        echo "<meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">";
        echo "<title>Test task</title>";
        echo "<link rel=\"stylesheet\" href=\"../front/style.css\">";
        echo "<link rel=\"stylesheet\" href=\"../front/media.css\">";
        echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>";
        echo "</head>";
    }

    public function header()
    {
        echo "<body>";
        echo '<p style="position: absolute; right: 0; top: 0;"><a href="/"><svg style="width: 50px; height: 50px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1080" zoomAndPan="magnify" viewBox="0 0 810 809.999993" height="1080" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="id1"><path d="M 258 268 L 576 268 L 576 618.191406 L 258 618.191406 Z M 258 268 " clip-rule="nonzero"/></clipPath><clipPath id="id2"><path d="M 190.929688 191.441406 L 642.429688 191.441406 L 642.429688 418 L 190.929688 418 Z M 190.929688 191.441406 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path fill="rgb(0%, 0%, 0%)" d="M 575.1875 408.367188 Z M 575.1875 408.367188 L 416.726562 268.1875 L 258.171875 408.421875 L 258.171875 608.804688 C 258.171875 613.980469 262.359375 618.132812 267.539062 618.132812 L 366.628906 618.132812 L 366.628906 530.273438 C 366.628906 525.097656 370.785156 520.917969 375.964844 520.917969 L 457.386719 520.917969 C 462.566406 520.917969 466.722656 525.097656 466.722656 530.273438 L 466.722656 618.132812 L 565.839844 618.132812 C 571.023438 618.132812 575.179688 613.980469 575.179688 608.804688 L 575.179688 408.355469 Z M 258.171875 408.425781 Z M 258.171875 408.425781 " fill-opacity="1" fill-rule="nonzero"/></g><g clip-path="url(#id2)"><path fill="rgb(0%, 0%, 0%)" d="M 415.804688 191.476562 L 190.929688 390.359375 L 214.617188 417.054688 L 416.726562 238.292969 L 618.785156 417.054688 L 642.429688 390.359375 L 417.601562 191.476562 L 416.730469 192.484375 L 415.808594 191.476562 Z M 415.804688 191.476562 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="rgb(0%, 0%, 0%)" d="M 258.171875 220.105469 L 315.179688 220.105469 L 314.679688 253.832031 L 258.171875 304.824219 Z M 258.171875 220.105469 " fill-opacity="1" fill-rule="nonzero"/></svg></a></p>';
        if (!isset($this->user)) {
            echo '<p><a href="/login/">Войти</a> в систему</p>';
            echo '<p><a href="/data/">Структура данных</a></p>';
        } else {
            echo '<p><a href="/logout/">Выйти</a> из системы</p>';
            echo '<p><a href="/register/">Зарегистрировать</a> нового администратора</p>';
            echo '<p><a href="/admin-data/">Структура данных</a></p>';
        }
    }

    public function middle()
    {
        echo static::class;
    }

    public function view()
    {
        $this->head();
        $this->header();
        $this->middle();
        $this->footer();
    }

    private function footer()
    {
        echo '</body></html>';
    }
}