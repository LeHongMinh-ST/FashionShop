<?php
require_once 'Controller.php';

class App extends Controller
{
    protected $mod = 'HomeController';
    protected $act = 'index';
    protected $prarams = [];

    public function __construct()
    {
        $url = $this->urlProcess();
        ucfirst($url[0]);

        //Xử lý lấy controller
        if (file_exists("./app/controllers/" . ucfirst($url[0]) . "Controller.php")) {
            $this->mod = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        $controller = $this->controller($this->mod);


        //Xử lý lấy action
        if (isset($url[1])) {
            if (method_exists($controller, ucfirst($url[1]))) {
                $this->act = ucfirst($url[1]);
                unset($url[1]);
            }
        }

        //XỬ lý các biến truyền vào phương thức
        $this->prarams = $url ? array_values($url) : [];

        //Thực thi chức năng
        call_user_func_array([$controller, $this->act], $this->prarams);

    }

    public function urlProcess()
    {
        if (isset($_GET["url"])) {
            $url = $_GET["url"];
            $url = $url[strlen($url) - 1] == "/" && strlen($url) != 1 ? $url : $url . "/";
            return explode("/", filter_var(trim($url)));
        }
        return [""];
    }
}