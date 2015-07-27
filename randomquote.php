<?php
$items = array(
  "There is no place like 127.0.0.1",
  "There is no place like ~",
  "There is no place like lo0",
  "There is no place like ::1",
  "There is no place like 01101000011011110110110101100101",
  "There is no place like C:\\",
  "There is no place like poolen",
  "\"Mindre uselt n0llan\" är ett anagram för \"Tullens mandoliner\"");
echo $items[array_rand($items)] . ".";
?>
