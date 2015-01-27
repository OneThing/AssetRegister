
<?php
   {
   if ($_FILES["file"]["error"] > 0)
     {
     echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
     }
   else
     {
     echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	 echo "<br />";
     if (file_exists("files/" . $_FILES["file"]["name"]))
       {
       echo $_FILES["file"]["name"] . " already exists. Please rename file and try again ";
       }
     else
       {
       move_uploaded_file($_FILES["file"]["tmp_name"],
       "files/" . $_FILES["file"]["name"]);
       echo "File upload complete";
       }
     }
   }
 ?>