<?php

namespace GB\Dice;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;

/**
 * Example test class.
 */
class DiceControllerTest extends TestCase
{
    private $controller;
    private $app;
    /**
     * testing init and roll, asserting returns array of correct size
     */
    protected function setUp(): void
    {
        global $di;
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $app;
        $di->set("app", $app);

        $this->controller = new DiceController;
        $this->controller->setApp($app);
    }
    //
    // /**
    //  * testing sum method
    //  */
    public function testInitAction()
    {
        $res = $this->controller->initAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    //
    // /**
    //  * testing sum method
    //  */
    public function testPlayActionGet()
    {
        $res = $this->controller->playActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    //
    // /**
    //  * testing sum method
    //  */
    public function testPlayActionPostRoll()
    {
        $this->app->request->setGlobals([
            "post" => [
                "roll" => "hej"
            ]
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testPlayActionPostInit()
    {
        $this->app->request->setGlobals([
            "post" => [
                "doInit" => "hej"
            ]
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testPlayActionPostSave()
    {
        $this->app->request->setGlobals([
            "post" => [
                "saveSum" => "hej"
            ]
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
