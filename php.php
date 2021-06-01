<?php

class MetaIterator
{
    private $patterns = array('~<meta .*>~mui', '~<title>.*<\/title>~mui');
    private $taglist = [];
    public function __construct(string $text)
    {
        foreach ($this->patterns as $pattern) {
            preg_match_all($pattern, $text, $matches);
            $this->taglist = array_merge($this->taglist, $matches);
        }
    }
    private function recScan($array)
    {
        $iterator = new RecursiveArrayIterator($array);
        while ($iterator->valid()) {
            if ($iterator->hasChildren()) {
                $this->recScan(iterator_to_array($iterator->getChildren()));
            } else {
                echo htmlspecialchars($iterator->current()) . '<br>';
            }
            $iterator->next();
        }
    }
    public function getTagList()
    {
        $this->recScan($this->taglist);
    }
}
$code = file_get_contents('code.html');
$scan = new MetaIterator($code);
$result = $scan->getTagList();




