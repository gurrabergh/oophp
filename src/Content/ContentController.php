<?php

namespace GB\Content;

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
class ContentController implements AppInjectableInterface
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
    public function allAction() : object
    {
        $title = "Movie database | oophp";

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);
        $data["res"] = $res;

        $this->app->page->add("content/header");
        $this->app->page->add("content/show-all", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function adminAction() : object
    {
        $title = "Movie database | oophp";

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);
        $data["res"] = $res;

        $this->app->page->add("content/header");
        $this->app->page->add("content/admin", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionGet()
    {
        $this->app->db->connect();
        $contentId = $this->app->request->getGet("id");
        if (!is_numeric($contentId)) {
            $this->app->page->add("content/header");
            $this->app->page->add("content/404");
            return $this->app->page->render();
        }
        $this->app->db->connect();
        $title = "Content edit | oophp";
        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $this->app->db->executeFetchAll($sql, [$contentId]);
        $content = $content[0];
        $message = $this->app->session->get("message") ?? "";
        $data["content"] = $content;
        $data["message"] = $message;
        $this->app->page->add("content/header");
        $this->app->page->add("content/edit", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost() : object
    {
        $filter = new \GB\MyTextFilter\MyTextFilter();
        $this->app->db->connect();
        $contentId      = $this->app->request->getPost("contentId");
        $contentTitle   = $this->app->request->getPost("contentTitle");
        $contentPath    = $this->app->request->getPost("contentPath");
        $contentSlug    = $this->app->request->getPost("contentSlug");
        $contentData    = $this->app->request->getPost("contentData");
        $contentType    = $this->app->request->getPost("contentType");
        $contentFilter  = $this->app->request->getPost("contentFilter");
        $contentPublish = $this->app->request->getPost("contentPublish");
        if (!$contentSlug) {
            $contentSlug  = $filter->slugify($contentTitle);
        }

        if (!$contentPath) {
            $contentPath = null;
        }

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        try {
            $this->app->db->execute($sql, [$contentTitle, $contentPath, $contentSlug, $contentData, $contentType, $contentFilter, $contentPublish, $contentId]);
        } catch (\Exception $e) {
            $this->app->session->set("message", "Invalid slug. Please enter another slug.");
            return $this->app->response->redirect("content/edit?id=$contentId");
        }
        $this->app->session->set("message", "");
        return $this->app->response->redirect("content/admin");
    }

    public function deleteActionGet()
    {
        $this->app->db->connect();
        $contentId = $this->app->request->getGet("id");
        $this->app->db->connect();
        $title = "Content edit | oophp";
        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $this->app->db->executeFetchAll($sql, [$contentId]);
        $content = $content[0];
        $data["content"] = $content;
        $this->app->page->add("content/header");
        $this->app->page->add("content/delete", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    //
    public function deleteActionPost() : object
    {
        $this->app->db->connect();
        $contentId    = $this->app->request->getPost("contentId");

        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->app->db->execute($sql, [$contentId]);
        return $this->app->response->redirect("content/admin");
    }

    public function createActionGet()
    {
        $title = "Content create | oophp";
        $this->app->page->add("content/header");
        $this->app->page->add("content/create");


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function createActionPost()
    {
        $this->app->db->connect();
        $title = $this->app->request->getPost("contentTitle");
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->app->db->execute($sql, [$title]);
        $id = $this->app->db->lastInsertId();
        return $this->app->response->redirect("content/edit?id=$id");


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function pagesActionGet()
    {
        $title = "Content pages | oophp";
        $this->app->db->connect();


        $sql = <<<EOD
SELECT
*,
CASE
WHEN (deleted <= NOW()) THEN "isDeleted"
WHEN (published <= NOW()) THEN "isPublished"
ELSE "notPublished"
END AS status
FROM content
WHERE type=?
;
EOD;

        $res = $this->app->db->executeFetchAll($sql, ["page"]);
        $data["res"] = $res;

        $this->app->page->add("content/header");
        $this->app->page->add("content/pages", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function blogActionGet()
    {
        $title = "Content blog | oophp";
        $this->app->db->connect();


        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
AND (deleted IS NULL OR deleted > NOW())
ORDER BY published DESC
;
EOD;
        $res = $this->app->db->executeFetchAll($sql, ["post"]);
        $data["res"] = $res;

        $this->app->page->add("content/header");
        $this->app->page->add("content/blog", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function pageActionGet()
    {
        $textFilter = new \GB\MyTextFilter\MyTextFilter();
        $title = "Content blog | oophp";
        $this->app->db->connect();
        $path = $this->app->request->getGet("path");
        if ($path == "") {
            $path = null;
        }

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $res = $this->app->db->executeFetch($sql, [$path, "page"]);
        if (!$res) {
            $this->app->page->add("content/header");
            $this->app->page->add("content/404");
            return $this->app->page->render([
                "title" => $title,
            ]);
        }
        $filter = explode(",", $res->filter);
        $res->data = $textFilter->parse($res->data, $filter);
        $data["content"] = $res;

        $this->app->page->add("content/header");
        $this->app->page->add("content/page", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function blogpostActionGet()
    {
        $textFilter = new \GB\MyTextFilter\MyTextFilter();
        $title = "Content blog | oophp";
        $this->app->db->connect();
        $slug = $this->app->request->getGet("s");

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $res = $this->app->db->executeFetch($sql, [$slug, "post"]);
        if (!$res) {
            $this->app->page->add("content/header");
            $this->app->page->add("content/404");
            return $this->app->page->render([
                "title" => $title,
            ]);
        }
        $filter = explode(",", $res->filter);
        $res->data = $textFilter->parse($res->data, $filter);
        $data["content"] = $res;

        $this->app->page->add("content/header");
        $this->app->page->add("content/blogpost", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
