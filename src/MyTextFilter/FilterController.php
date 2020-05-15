<?php

namespace GB\MyTextFilter;

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
class FilterController implements AppInjectableInterface
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
    public function indexActionGet() : object
    {
        $text = file_get_contents(__DIR__ . "./text/bbcode.txt");
        $title = "bbcode | oophp";

        $filter = new MyTextFilter();
        $html = $filter->parse($text, ["bbcode", "nl2br"]);
        $data["html"] = $html;
        $data["text"] = $text;

        $this->app->page->add("filter/header");
        $this->app->page->add("filter/bbcode", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function markdownActionGet() : object
    {
        $text = file_get_contents(__DIR__ . "./text/sample.md");
        $title = "bbcode | oophp";

        $filter = new MyTextFilter();
        $html = $filter->parse($text, ["markdown"]);
        $data["html"] = $html;
        $data["text"] = $text;

        $this->app->page->add("filter/header");
        $this->app->page->add("filter/markdown", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function clickActionGet() : object
    {
        $text = file_get_contents(__DIR__ . "./text/clickable.txt");
        $title = "bbcode | oophp";

        $filter = new MyTextFilter();
        $html = $filter->parse($text, ["link"]);
        $data["html"] = $html;
        $data["text"] = $text;

        $this->app->page->add("filter/header");
        $this->app->page->add("filter/clickable", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
