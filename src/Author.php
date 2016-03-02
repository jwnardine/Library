<?php
    class Author
    {
        private $author_name;
        private $id;

        function __construct($author_name, $id = null)
        {
            $this->author_name = $author_name;
            $this->id = $id;
        }

        function setAuthor_Name($new_author_name)
        {
            $this->author_name = (string) $new_author_name;
        }

        function getAuthor_Name()
        {
            return $this->author_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
              $GLOBALS['DB']->exec("INSERT INTO authors (author)  VALUES ('{$this->getAuthor_Name()}');");
              $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();
            foreach($returned_authors as $author) {
                $author_name = $author['author'];
                $id = $author['id'];
                $new_author = new Author($author_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $search_id) {
                  $found_author = $author;
                }
            }
            return $found_author;
        }

        function update($new_author_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET author = '{$new_author_name}' WHERE id = {$this->getId()};");
            $this->setAuthor_Name($new_author_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE author_id = {$this->getId()};");
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT book_id FROM authors_books WHERE author_id = {$this->getId()};");

            $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $books = array();

            foreach($book_ids as $id) {
                $book_id = $id['book_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$book_id};");
                $returned_book = $result->fetchAll(PDO::FETCH_ASSOC);
                $title = $returned_book[0]['title'];
                $id = $returned_book[0]['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
          }
          return $books;
        }
    }
?>
