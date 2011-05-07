<?php

  $FileReference = $_FILES['uploadedfile']['tmp_name'];

  header("Content-type: text/plain");

  # This is an automated version of this manual process:
  # http://www.bellsmind.net/Bells_Mind/Blog/Entries/2004/9/11_New_conference_sounds.html

  if(is_uploaded_file($FileReference))
  {
    $data = shell_exec ("/usr/bin/sox -t wav $FileReference -r 8000 -t ul - resample -ql | /usr/bin/od -t x1 - | sed -e 's/^.......//' -e 's/ //g' | tr -d '\n' | sed -e 's/\([0-9a-f]\{2\}\)/0x\\1/g' -e 's/\([0-9a-f]\)\(0x\)/\\1, \\2/g' -e 's/\([0-9a-f]\{2\}\)\([0-9a-f]\)$/\\1/' -e 's/\(.\{60\}\)/\\1\\n/g'");

    # At this point we have a blob of data

    if($_POST['enter'] == "on")
    {
      print "static unsigned char enter[] = {\n";
    }
    else
    {
      print "static unsigned char leave[] = {\n";
    }

    print $data;
    print "\n};";
  }
  else
  {
    print "No file uploaded";
  }

?>
