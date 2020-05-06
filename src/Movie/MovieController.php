<?php

namespace GB\Movie;

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
class MovieController implements AppInjectableInterface
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
    public function showAction() : object
    {
        $title = "Movie database | oophp";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);
        $data["res"] = $res;

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/show-all", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function searchYearAction() : object
    {
        $title = "Movie search | oophp";
        $year1 = $this->app->request->getGet("year1");
        $year2 = $this->app->request->getGet("year2");
        $data["year1"] = $year1 ?? "";
        $data["year2"] = $year2 ?? "";

        $this->app->db->connect();

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/search-year", $data);
        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
            $data["res"] = $res;
            $this->app->page->add("movie/show-all", $data);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $res = $this->app->db->executeFetchAll($sql, [$year2]);
        }

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function searchTitleActionGet() : object
    {
        $title = "Movie search | oophp";
        $searchTitle = $this->app->request->getGet("searchTitle");
        $data["searchTitle"] = $searchTitle ?? "";

        $this->app->db->connect();

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/search-title", $data);
        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$searchTitle]);
            $data["res"] = $res;
            $this->app->page->add("movie/show-all", $data);
        }

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function createActionGet()
    {
        $this->app->db->connect();
        $title = "Movie edit | oophp";
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $this->app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
        $movieId = $this->app->db->lastInsertId();
        return $this->app->response->redirect("movie/edit?id=$movieId");
    }

    public function editActionGet()
    {
        $this->app->db->connect();
        $movieId = $this->app->request->getGet("id");
        $this->app->db->connect();
        $title = "Movie edit | oophp";
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $this->app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];
        $data["movie"] = $movie;
        $this->app->page->add("movie/header");
        $this->app->page->add("movie/edit", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost() : object
    {
        $this->app->db->connect();
        $title = "Movie database | oophp";
        $movieId    = $this->app->request->getPost("movieId");
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear  = $this->app->request->getPost("movieYear");
        $movieImage = $this->app->request->getPost("movieImage");

        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);

        return $this->app->response->redirect("movie/show");
    }

    public function deleteActionGet()
    {
        $this->app->db->connect();
        $movieId = $this->app->request->getGet("id");
        $this->app->db->connect();
        $title = "Movie edit | oophp";
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $this->app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];
        $data["movie"] = $movie;
        $this->app->page->add("movie/header");
        $this->app->page->add("movie/delete", $data);


        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteActionPost() : object
    {
        $this->app->db->connect();
        $title = "Movie database | oophp";
        $movieId    = $this->app->request->getPost("movieId");

        $sql = "DELETE FROM movie WHERE id = ?;";
        $this->app->db->execute($sql, [$movieId]);
        return $this->app->response->redirect("movie/show");
    }
}
