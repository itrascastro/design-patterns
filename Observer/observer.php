<?php
 
/**
 * Subject,that who makes news
 */
class Newspaper implements \SplSubject
{
    private $name;
    private $observers = array();
    private $content;
    
    public function __construct($name) 
    {
        $this->name = $name;
    }
 
    //add observer
    public function attach(\SplObserver $observer) 
    {
        $this->observers[] = $observer;
    }
    
    //remove observer
    public function detach(\SplObserver $observer) 
    {
        
        $key = array_search($observer,$this->observers, true);
        if($key) {
            unset($this->observers[$key]);
        }
    }
    
    //set breakouts news
    public function breakOutNews($content) 
    {
        $this->content = $content;
        $this->notify();
    }
    
    public function getContent() 
    {
        return $this->content." ({$this->name})";
    }
    
    //notify observers(or some of them)
    public function notify() 
    {
        foreach ($this->observers as $value) 
        {
            $value->update($this);
        }
    }
}
 
/**
 * Observer,that who recieves news
 */
class Reader implements SplObserver
{
    private $name;
    
    public function __construct($name) 
    {
        $this->name = $name;
    }
    
    public function update(\SplSubject $subject) 
    {
        echo $this->name.' is reading breakout news <b>'.$subject->getContent().'</b><br>';
    }
}
 
/**
 * Generates new content for the newspaper
 */
Class Journalist
{
    private $_name;
    private $_news;
    private $_newsPaper;
 
    public function __construct($_name, $_newsPaper)
    {
        $this->_name        = $_name;
        $this->_newsPaper   = $_newsPaper;
    }
 
    public function publish($_news)
    {
        $this->_news = $_news;
        $this->_newsPaper->breakOutNews($this->_news . ' published by ' . $this->_name);
    }
}
 
$newspaper = new Newspaper('Newyork Times');
 
$journalist1 = new Journalist('journalist1', $newspaper);
$journalist2 = new Journalist('journalist2', $newspaper);
$journalist3 = new Journalist('journalist3', $newspaper);
 
$allen = new Reader('Allen');
$jim = new Reader('Jim');
$linda = new Reader('Linda');
 
//add reader
$newspaper->attach($allen);
$newspaper->attach($jim);
$newspaper->attach($linda);
 
//remove reader
$newspaper->detach($linda);
 
 
//set break outs
$journalist1->publish('News1');
$journalist2->publish('News2');
$journalist3->publish('News3');
 
//=====output======
// Allen is reading breakout news News1 published by journalist1 (Newyork Times)
// Jim is reading breakout news News1 published by journalist1 (Newyork Times)
// Allen is reading breakout news News2 published by journalist2 (Newyork Times)
// Jim is reading breakout news News2 published by journalist2 (Newyork Times)
// Allen is reading breakout news News3 published by journalist3 (Newyork Times)
// Jim is reading breakout news News3 published by journalist3 (Newyork Times)