<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Author.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    Class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();

        }

        function testGetAuthor_Name()
        {
            $author_name = "Matt";
            $test_author = new Author($author_name);

            $result = $test_author->getAuthor_Name();

            $this->assertEquals($author_name, $result);
        }

        function testSetAuthor()
        {
           //Arrange
           $author_name = "Matt";
           $test_author = new Author($author_name);
           //Act
           $test_author->setAuthor_Name("Matt");
           $result = $test_author->getAuthor_Name();
           //Assert
           $this->assertEquals("Matt", $result);
        }

       function testGetId()
        {
            //Arrange
            $author_name = "Matt";
            $id = 1;

            $test_author = new Author($author_name, $id);
            //Act
            $result = $test_author->getId();
            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
       {
           //Arrange

           $author_name = "Matt";
           $test_author = new Author($author_name);
           //Act
           $test_author->save();
           //Assert
           $result = Author::getAll();

           $this->assertEquals($test_author, $result[0]);
       }

        function test_getAll()
         {
            //Arrange
            $author_name = "Matt";
            $author_name2 = "Jon";
            $test_author = new Author($author_name);
            $test_author->save();
            $test_author2 = new Author($author_name2);
            $test_author2->save();
            //Act
            $result = Author::getAll();
            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
         }


        function testDeleteAll()
        {
            //Arrange
            $author_name = "Matt";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Jon";
            $id2 = 2;
            $test_author2 = new Author($author_name2, $id2);
            $test_author2->save();
            //Act
            Author::deleteAll();
            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $author_name = "Matt";
            $author_name2 = "Jon";
            $test_author = new Author($author_name);
            $test_author->save();
            $test_author2 = new Author($author_name2);
            $test_author2->save();
            //Act
            $result = Author::find($test_author->getId());
            //Assert
            $this->assertEquals($test_author, $result);
        }

        function testUpdate()
         {
            //Arrange
            $author_name = "Matt";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();
            $new_author_name = "Matthew";
            //Act
            $test_author->update($new_author_name);
            //Assert
            $this->assertEquals("Matthew", $test_author->getAuthor_Name());
         }

         function testAddBook()
        {
            //Arrange
            $author_name = "Matt";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $title = "How to Cook Steak";
            $id2 = 2;
            $test_book = new Book($title, $id2);
            $test_book->save();
            //Act
            $test_author->addBook($test_book);
            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book]);
        }

        function testGetBooks()
        {
        //Arrange
            $author_name = "Matt";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $title = "Matt and his Guide to Stuff";
            $id2 = 2;
            $test_book = new Book($title, $id2);
            $test_book->save();

            $title2 = "Matt and his World";
            $id3 = 3;
            $test_book2 = new Book($title2, $id3);
            $test_book2->save();
            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }

        function testDelete()
        {
            //Arrange
            $author_name = "Matt";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $title = "Matt and his Guide to Stuff";
            $id2 = 2;
            $test_book = new Book($title, $id2);
            $test_book->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->delete();
            //Assert
            $this->assertEquals([], $test_book->getAuthors());
        }
    }
?>
