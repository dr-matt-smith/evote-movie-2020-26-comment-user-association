<?php


namespace Tudublin;


use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

class MovieController extends Controller
{
    public function listMovies()
    {
        $movies = $this->movieRepository->findAll();
        $comments = $this->commentRepository->findAll();

        // reverse array - so most recent comments appear first ...
        $comments = array_reverse($comments);

        $template = 'list.html.twig';
        $args = [
            'movies' => $movies,
            'comments' => $comments
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id');
        $success = $this->movieRepository->delete($id);

        if($success){
            $this->listMovies();
        } else {
            $message = 'there was a problem trying to delete Movie with ID = ' . $id;
            $this->error($message);
        }
    }

    public function error($errorMessage)
    {
        $template = 'error.html.twig';
        $args = [
        'errorMessage' => $errorMessage
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function createForm($errors = [], $movie = null)
    {
        $template = 'newMovieForm.html.twig';

        if(count($errors) > 0) {
            $args = [
                'errors' => $errors,
                'movie' => $movie
            ];
        } else{
            $args = [];
        };

        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processNewMovie()
    {
        $title = filter_input(INPUT_POST, 'title');
        $category = filter_input(INPUT_POST, 'category');
        $price = filter_input(INPUT_POST, 'price');

        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setCategory($category);
        $movie->setPrice($price);
        $movie->setVoteTotal(0);
        $movie->setNumVotes(0);

        $errors = $this->validateMovie($movie);

        if(!empty($errors)){
            // invoke create form again - passing movie object and error array
            $this->createForm($errors, $movie);

        } else {
            // add movie to DB & list movies
            $this->movieRepository->create($movie);
            $this->listMovies();
        }
    }

    private function validateMovie(Movie $movie)
    {
        $errors = [];

        // title
        if(empty($movie->getTitle())){
            $errors[] = "title :: must have a value";
        } else {
            if(strlen($movie->getTitle()) < 3) {
                $errors[] = "title :: must have at least 3 characters";
            }
        }

        // category
        if(empty($movie->getCategory())){
            $errors[] = "category :: must have a value";
        } else {
            if(strlen($movie->getCategory()) < 3) {
                $errors[] = "category :: must have at least 3 characters";
            }
        }

        // price
        if(empty($movie->getPrice())) {
            $errors[] = "price :: must have a value";
        } else {
            if(!is_numeric($movie->getPrice())) {
                $errors[] = "price :: must be a number";
            }
        }

        return $errors;
    }

    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id');
        $movie = $this->movieRepository->find($id);

        // if not NULL pass Movie object to editForm method
        if($movie){
            $this->editForm($movie);
        } else {
            $message = 'there was a problem trying to edit Movie with ID = ' . $id;
            $this->error($message);
        }
    }


    public function editForm($movie)
    {
        $template = 'editMovieForm.html.twig';
        $args = [
            'movie' => $movie
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processUpdateMovie()
    {
        $id = filter_input(INPUT_POST, 'id');
        $title = filter_input(INPUT_POST, 'title');
        $category = filter_input(INPUT_POST, 'category');
        $price = filter_input(INPUT_POST, 'price');
        $voteTotal = filter_input(INPUT_POST, 'voteTotal');
        $numVotes = filter_input(INPUT_POST, 'numVotes');

        $m = new Movie();
        $m->setId($id);
        $m->setTitle($title);
        $m->setCategory($category);
        $m->setPrice($price);
        $m->setVoteTotal($voteTotal);
        $m->setNumVotes($numVotes);

        $success = $this->movieRepository->update($m);

        if($success){
            $this->listMovies();
        } else {
            $message = 'there was a problem trying to EDIT Movie with ID = ' . $id;
            $this->error($message);
        }
    }


}

