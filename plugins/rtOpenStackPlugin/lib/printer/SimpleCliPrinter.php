<?php
class SimpleCliPrinter
{

  public function __construct(array $columns)
  {
    $this->columns = $columns;
  }

  public function render($data)
  {
    // calculate max field size
    $result = array();
    $sizes  = array();
    foreach($data as $i => $row)
    {
      foreach($this->columns as $c)
      {
        $sizes[$c] = max(mb_strlen($row[$c]), mb_strlen($c), isset($sizes[$c]) ? $sizes[$c] : 8);
      }
    }

    // render headers
    $this->renderSeparatorLine($sizes);
    foreach($this->columns as $c)
    {
      $size = $sizes[$c];
      printf(' %-'.$size.'s |', $c);
    }
    echo "\n";
    $this->renderSeparatorLine($sizes);

    foreach($data as $i => $row)
    {
      foreach($this->columns as $c)
      {
        $item = $row[$c];
        $size = $sizes[$c];
        printf(' %-'.$size.'s |', $item);
      }
      echo "\n";
    }
    $this->renderSeparatorLine($sizes);
  }

  private function renderSeparatorLine($sizes)
  {
    foreach($this->columns as $c)
    {
      $size = max($sizes[$c], 8);
      printf('-%\'--'.$size.'s-|', '-');
    }
    echo "\n";
  }
}
