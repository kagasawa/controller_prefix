<?php
App::uses('CakeRoute', 'Routing/Route');

class ControllerPrefixRoute extends CakeRoute {

    /**
     * parse
     *
     * @param $url
     * @return
     */
    public function parse($url){
        
        if (preg_match('#^/' . $this->defaults['controllerPrefix'] . '/([^/:]+)/(.+)#', $url, $matches)) {
            $c = 'admin/' . $matches[1];
            if (preg_match('#^/' . $c . '(/?)([^/]*)/?(.*)#', $url, $matches)) {
                if ($matches[1] === '') {
                    $url .= '/';
                }
                if ($matches[2] === '') {
                    $url .= 'index';
                }
                if (strpos($matches[2], ':')) {
                    unset($matches[0]);
                    unset($matches[1]);
                    $url = '/' . $c . '/index/' . implode('/', $matches);
                }
            }
        } else if (preg_match('#^/' . $this->defaults['controllerPrefix'] . '/([^/:]+)/?$#', $url, $matches)) {
            $url = '/admin/' . $matches[1] . '/index';
        }
        $route = parent::parse($url);
        if (is_array($route)) {
                $route['controller'] = $this->defaults['controllerPrefix'] . '_' . $route['controller'];
        }
        
        return $route;
    }

    /**
     * match
     *
     * @param $url
     * @return
     */
    public function match($url){
        
        if (preg_match('/^' . $this->defaults['controllerPrefix'] . '_/', $url['controller'])) {
            
            $connectNamed = Router::connectNamed(false);
            $separator = $connectNamed['separator'];
            
            $url['controller'] = preg_replace('/^' . $this->defaults['controllerPrefix'] . '_/', '', $url['controller']);

            $u = '/' . $this->defaults['controllerPrefix'] . '/' . $url['controller'];

            if ($url['action'] !== 'index') {
                 $u .= '/' . $url['action'];
            }

            unset($url['controller']);
            unset($url['action']);
            unset($url['plugin']);
            unset($url['prefix']);

            foreach ($url as $key => $value) {
                if (is_numeric($key)) {
                    $u .= '/' . $value;
                } else {
                    $u .= '/' . $key . $separator . $value;
                }
            }
            return $u;
        }
    }
  }