<?php

namespace GB\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        // init session for game start

        $this->app->session->set("game", new DiceGame());

        return $this->app->response->redirect("diceC/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game";
        $game = $this->app->session->get("game");
        $data = [
            "lastRoll" => $game->getLastRoll(),
            "playerScore" => $game->getPlayerScore(),
            "cpuScore" => $game->getCpuScore(),
            "sum" => $game->getLastRollSum ?? 0,
            "turn" => $game->getTurn(),
            "pot" => $game->getPot(),
            "cpuMessage" => $game->getCpuMessage() ?? null,
            "histogram" => $game->getAsText()
        ];

        $this->app->page->add("diceC/play", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     *
     *
     *
     *
     * @return object
     */
    public function playActionPost() : object
    {
        $request = $this->app->request;
        $game = $this->app->session->get("game");
        $roll = $request->getPost("roll");
        $saveSum = $request->getPost("saveSum");
        $doInit = $request->getPost("doInit");

        if ($roll) {
            $game->diceRoll();
        }
        //
        if ($saveSum) {
            $game->saveSum();
        }
        //
        if ($doInit) {
            return $this->app->response->redirect("diceC/init");
        }

        return $this->app->response->redirect("diceC/play");
    }
}
