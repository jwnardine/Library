<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    Class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Author::deleteAll()
        }

        function testGetAuthor()
        {
            $author = "Matt";
            $test_author = new Author($author);

            $result = $test_author->GetAuthor();

            $this->assertEquals($author, $result);
        }

        function testSetAuthor()
        {
           //Arrange
           $author = "Matt";
           $test_author = new Author($author);
           //Act
           $test_author->setAuthor("Matt");
           $result = $test_author->getAuthor();
           //Assert
           $this->assertEquals("Matt", $result);
        }

       function testGetId()
        {
            //Arrange
            $author = "Matt";
            $id = 1;

            $test_author = new Author($author, $id);
            //Act
            $result = $test_author->getId();
            //Assert
            $this->assertEquals(1, $result);
        }
    }
?>
