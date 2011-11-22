<?php
App::import('Routing', 'Dispatcher');
App::import('Lib', 'ControllerPrefix.ControllerPrefixRoute');

class ControllerPrefixRoutingTestCase extends ControllerTestCase {

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        
        Router::connect('/admin/:controller/:action/*',
                        array('controllerPrefix' => 'admin'), array('routeClass' => 'ControllerPrefixRoute'));
        
        require_once CAKE . 'Config' . DS . 'routes.php';
        
        $this->Dispatcher = new Dispatcher();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Dispatcher);
        parent::tearDown();
    }

    /**
     * testParse
     *
     */
    public function testParse(){

        $params = $this->Dispatcher->parseParams(new CakeRequest('/users/'));
        $this->assertIdentical('users', $params->params['controller']);
        $this->assertIdentical('index', $params->params['action']);
        $this->assertIdentical(array(), $params->params['pass']);
        $this->assertIdentical(array(), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users/'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('index', $params->params['action']);
        $this->assertIdentical(array(), $params->params['pass']);
        $this->assertIdentical(array(), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users/edit/1'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('edit', $params->params['action']);
        $this->assertIdentical(array('0' => '1'), $params->params['pass']);
        $this->assertIdentical(array(), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/admin/edit/1'));
        $this->assertIdentical('admin_admin', $params->params['controller']);
        $this->assertIdentical('edit', $params->params['action']);
        $this->assertIdentical(array('0' => '1'), $params->params['pass']);
        $this->assertIdentical(array(), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users/edit/1/page:2'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('edit', $params->params['action']);
        $this->assertIdentical(array('0' => '1'), $params->params['pass']);
        $this->assertIdentical(array('page' => '2'), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('index', $params->params['action']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users/page:2'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('index', $params->params['action']);
        $this->assertIdentical(array('page' => '2'), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users/page:2'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('index', $params->params['action']);
        $this->assertIdentical(array('page' => '2'), $params->params['named']);

        $params = $this->Dispatcher->parseParams(new CakeRequest('/admin/users/page:2/sort:3'));
        $this->assertIdentical('admin_users', $params->params['controller']);
        $this->assertIdentical('index', $params->params['action']);
        $this->assertIdentical(array('page' => '2', 'sort' => '3'), $params->params['named']);
    }

    /**
     * testMatch
     *
     * @return
     */
    function testMatch(){
        $url = Router::url(array('controller' => 'admin_users', 'action' => 'edit',2));
        $this->assertIdentical('/admin/users/edit/2', $url);
    }
}
