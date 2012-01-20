<?php

require_once("./include/fgcontactform.php");
$formproc = new FGContactForm();



if(isset($_POST['submitted']))
{
    if($formproc->ProcessForm())
    {
        echo "success";
    }
    else
    {
        echo $formproc->GetErrorMessage();
    }
}
?>
