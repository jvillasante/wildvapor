<?php

namespace SlimHelpers;

class MultilingualSlim extends \Slim\Slim {
    public function urlFor( $name, $params = array() ) {
        // return sprintf('/%s%s', $this->view()->getLang(), parent::urlFor($name, $params));
        return $this->request->getRootUri() . '/' . $this->view()->getLang() . $this->router->urlFor($name, $params);
    }
}
