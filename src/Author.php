<?php
    class Author
    {
        private $author;
        private $id;

        function __construct($author, $id = null)
        {
            $this->author = $author;
            $this->id = $id;
        }

        function setAuthor($new_author)
        {
            $this->author = (string) $new_author;
        }

        function getAuthor()
        {
            return $this->author;
        }

        function getId()
        {
            return $this->id;
        }

    }
?>
