<?php

// on checkout.html.tiwg: <h2>{{ book.getBookName }}</h2>

    //Loading class functionality
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/BookList.php";
    require_once __DIR__."/../src/Patron.php";


    //Silex preloads
    $app = new Silex\Application();
    $app['debug'] = true;

    //PDO setup
    $host = 'pgsql:host=ec2-107-21-105-116.compute-1.amazonaws.com:5432;dbname=dfsplu7v4em5bp';
    $user = 'zffdjhjhbmbqvm';
    $pass = '12AxQc_MA96c6ejgtLyNSfZaAm';
    $DB = new PDO($host, $user, $pass);
    //Mysql database info
    // $server = 'mysql:host=localhost;dbname=library';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);


    //Patch and delete functions from symfony
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    //Use silex to load page and twig path
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
                    'twig.path' => __DIR__.'/../views'
    ));

    //Index page rendering links to authors and books
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('authors' => Author::getAll(), 'books' => Book::getAll()));
    });

    //---------------------Begin Book Functionality------------------

    //Books page, lists, add, edit, or delete a book links.
    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    //Adds a new book to DB, renders to books.html
    $app->post("/books", function() use ($app) {
        $book_name = $_POST['book_name'];
        $book = new Book($book_name, $id=null);
        $book->save();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    //Showing a book's schedule of authors.  Renders to particular book's page with crud function
    $app->get("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    //Adds authors to books in the book.html file.
    $app->post("/add_author", function() use ($app) {
        $author = Author::find($_POST['author_id']);
        $book = Book::find($_POST['book_id']);
        $book->addAuthor($author);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    //Updates book, comes from book.html, posts back to books.html with updated book info
    $app->patch("/book/{id}/edit", function($id) use ($app){
        $new_book_name = $_POST['new_book_name'];
        $book = Book::find($id);
        $book->update($new_book_name);
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    //Deletes book, comes from book.html, posts back to books.html minus deleted book
    $app->get("/book/{id}/delete", function($id) use ($app) {
        $book = Book::find($id);
        $book->deleteOne();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    //Delete All Books from DB
    $app->post("/delete_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    //Add a book and associate an author
    $app->post("/addbookauthor", function() use ($app) {
      $book = new Book($_POST['book_name']);
      $book->save();
      $author = new Author($_POST['author_name']);
      $author->save();
      $author->addBook($book);
      return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

// -------------------------End Book Routes -------------------------


// -------------------------Begin Author Routes -------------------------



    //Main authors page, displays all authors.
    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    //Adds a new author to authors table.
    $app->post("/author", function() use ($app) {
        $id = null;
        $author = new Author($_POST['author_name'], $id);
        $author->save();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    //Listing all books for a selected author. Check all_books variable for error issue
    $app->get("/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });

    //Linking book to a authors on the author page
    $app->post("/add_book", function() use ($app) {
        $author = Author::find($_POST['author_id']);
        $book = Book::find($_POST['book_id']);
        $author->addBook($book);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'authors' => Author::getAll(), 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });

    //Deletes all authors, do not use :P
    $app->post("/delete_authors", function() use ($app) {
        Author::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    //Updates author, comes from author.html, posts back to authors.html
    $app->patch("/author/{id}/edit", function($id) use ($app){
        $new_author_name = $_POST['new_author_name'];
        $author = Author::find($id);
        $author->update($new_author_name);
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    //Deletes author, comes from author.html, posts back to authors.html
    $app->get("/author/{id}/delete", function($id) use ($app) {
        $author = Author::find($id);
        $author->deleteOne();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    //-------------------------------BookList functionality Begin -----------------------

    //Generating a list of matching books from booklist with authorId and bookId inputs.
    //Comes from book.html or author.html.
    $app->get("/booklist/{authorId}/{bookId}", function($authorId, $bookId) use ($app) {
        $author = Author::find($authorId);
        $author_id = $author->getId();
        $book = Book::find($bookId);
        $book_id = $book->getId();
        $book_list = BookList::findBookList($author_id, $book_id);
        return $app['twig']->render('booklist.html.twig', array('book_list' => $book_list, 'book' => $book, 'author' => $author, 'patrons' => Patron::getAll()));
    });

    $app->patch("/booklist/{authorId}/{bookId}", function($authorId, $bookId) use ($app) {
        $update_book = BookList::find('id', $_POST['booklist_id']);
        $due_date = $_POST['due_date'];
        $patron_id = $_POST['patron_id'];
        $update_book[0]->update($due_date, $patron_id);
        $author = Author::find($authorId);
        $author_id = $author->getId();
        $book = Book::find($bookId);
        $book_id = $book->getId();
        $book_list = BookList::findBookList($author_id, $book_id);
        return $app['twig']->render('booklist.html.twig', array('book_list' => $book_list, 'book' => $book, 'author' => $author, 'patrons' => Patron::getAll()));
    });

    $app->get("booklist/{bookId}/out/", function ($bookId) use ($app) {
        $column_id = 'id';
        $books = BookList::find($column_id, intval($bookId));
        $patrons = Patron::getAll();
        return $app['twig']->render('checkout.html.twig', array('book' => $books[0], 'patrons' => $patrons));
    });


    //----------------------------Add a Book functionality Begin -------------------------

    //Redirect for add a book page.
    $app->get("/add", function() use ($app) {
        $patrons = Patron::getAll();
        return $app['twig']->render('add.html.twig', array('patrons' => $patrons));
    });

    $app->post("/add", function() use ($app) {
        $patron_name = $_POST['patron_name'];
        $new_patron = new Patron($patron_name);
        $new_patron->save();
        $patrons = Patron::getAll();
        return $app['twig']->render('add.html.twig', array('patrons' => $patrons));
    });




    //End of app
    return $app;
?>
