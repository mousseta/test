<?php
require_once '../modele/Article.php';
require_once '../modele/User.php';

/**
 * Article test case.
 */
class ArticleTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Article
     */
    private $article;
    private $user;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated ArticleTest::setUp()
        $this->user = new User("victor","hugo","1987-10-10","victor","123456","victor@gmail.com");
        $this->user->setId(1);
        $this->article = new Article(1,"les souris","2005-10-20","14","les souris sont vertes",1);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ArticleTest::tearDown()
        $this->article = null;
        $this->user=null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    public function testArticle() {
        $this->assertSame('les souris', $this->article->getTitre());
        $this->assertSame("2005-10-20", $this->article->getDate());
        $this->assertSame($this->user->getId(),$this->article->getId());
    }
}

