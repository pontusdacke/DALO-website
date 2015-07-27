<?php

class NewsPost
{
  public $id;
  public $title;
  public $post;
  public $author;
  public $datePosted;
  public $moodImageUrl;

  function __construct($inId=null, $inTitle=null, $inPost=null, $inAuthorId=null, $inDatePosted=null, $inMoodImageUrl=null)
  {
    if (!empty($inId)) $this->id = $inId;
    if (!empty($inTitle)) $this->title = $inTitle;
    if (!empty($inPost)) $this->post = $inPost;
    if (!empty($inMoodImageUrl)) $this->moodImageUrl = $inMoodImageUrl;

    if (!empty($inDatePosted))
    {
      //$splitDate = explode("-", $inDatePosted);
      $this->datePosted = $inDatePosted; //$splitDate[1] . "/" . $splitDate[2] . "/" . $splitDate[0];
    }

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
