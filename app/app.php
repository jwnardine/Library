<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    $app = new Silex\Application();
    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('authors' => Author::getAll(), 'books' => Book::getAll()));
    });
    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });
    $app->post("/authors", function() use ($app) {
        $author_name = new Author($_POST['author_name']);
        $author_name->save();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });
    $app->get("/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });
    $app->get("/authors/{id}/edit", function($id) use($app){
        $author = Author::find($id);
        return $app['twig']->render('author_edit.html.twig', array('author' => $author));
    });
    $app->patch("authors/{id}", function($id) use ($app) {
        $author_name = $_POST['author_name'];
        $author = Author::find($id);
        $author->update($author_name);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks()));
    });
    $app->delete("/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $author->delete();
        return $app['twig']->render('index.html.twig', array('authors' => Author::getAll()));
    });
    $app->post("/add_books", function() use ($app) {
        $author = Author::find($_POST['author_id']);
        $book = Book::find($_POST['book_id']);
        $author->addBook($book);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'authors' => Author::getAll(), 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });
    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });
    $app->post("/books", function() use ($app) {
        $title = $_POST['title'];
        $book = new Book($title);
        $book->save();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });
    $app->get("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });
    $app->post("/add_authors", function() use($app){
      $author = Author::find($_POST['author_id']);
      $book = Book::find($_POST['book_id']);
      $book->addAuthor($author);
      return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });
    $app->post("/delete_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('author.html.twig');
    });
    $app->post("/delete_authors", function() use ($app) {
        Author::deleteAll();
        return $app['twig']->render('index.html.twig');
    });
    $app->delete("/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $author->delete();
        return $app['twig']->render('index.html.twig', array('authors' => Author::getAll()));
    });
    return $app;
 ?>
