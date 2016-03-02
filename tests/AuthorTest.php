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

    //     function testSetAuthor()
    //    {
    //        //Arrange
    //        $author = "Matt";
    //        $completed = true;
    //        $due_date = "2016-02-23";
    //        $test_task = new Task($description, $completed, $due_date);
    //        //Act
    //        $test_task->setDescription("Drink coffee.");
    //        $result = $test_task->getDescription();
    //        //Assert
    //        $this->assertEquals("Drink coffee.", $result);
    //    }
    }
?>
