<?php
  function getSimpById($id=null)
  {
    $items = array(
      "homer",
      "apu",
      "bart",
      "comicbookguy",
      "itchy",
      "krusty",
      "lisa",
      "maggie",
      "mr-burns",
      "ned-flanders",
      "ralph-wiggum",
      "smithers");
      /* "marge" För stort huvud. */
    if (!isset($id))
    {
        echo "Functin getSimpById called incorrectly.";
        die();
    }
    else if ($id > count($items)) {
      echo "getSimpById: id too high. Max: " . count($items);
      die();
    }
    include "simpson/" . $items[$id] . ".php";
  }
?>
