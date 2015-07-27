<?php

class Event
{
  public $id;
  public $name;
  public $time;
  public $location;
  public $description;
  public $authorId;

  function __construct($inId=null, $inName=null, $inTime=null, $inLocation=null, $inDescription=null, $inAuthorId=null)
  {
    if (!empty($inId)) $this->id = $inId;
    if (!empty($inName)) $this->name = $inName;
    if (!empty($inTime)) $this->time = $inTime;
    if (!empty($inDescription)) $this->description = $inDescription;
    if (!empty($inLocation)) $this->location = $inLocation;

    if (!empty($inAuthorId))
    {
      include 'expert/config.php';

      if ($statement = $mysqli->prepare("SELECT firstname, lastname FROM users WHERE id=?"))
      {
        $statement->bind_param("i", $inAuthorId);
        $statement->execute();
        $statement->bind_result($firstname, $lastname);
        while ($statement->fetch())
        {
          $this->author = $firstname . " " . $lastname;
        }
        $statement->close();
      }

      $mysqli->close();
    }
  }
}
?>
