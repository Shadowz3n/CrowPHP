<?php

class Login extends Controller {

    function Index () {
        
        echo "Login";
    }

    function subpage ($parameter = '') {
        
        $viewData = array(
            'parameter' => $parameter
        );
        $this->view('template/header');
        $this->view('dashboard/subpage', $viewData);
        $this->view('template/footer');
    }
}

?>