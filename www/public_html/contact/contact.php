<?php 
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php");
require($_SERVER['DOCUMENT_ROOT']."/vues/Headers/header.php");
?>
<link rel="stylesheet" type="text/css" href="contact.css" /> 
<link rel="icon" type="image/x-icon" href="5.png " />
    <main>
        <div class="contact-title"  >
        <h1>Bonjour</h1>
        <h1>Comment nous pourrions vous aider ?</h1>


    </div>
    <div class="contact-form">
        
        <form id="contact-form" action="index4.php" method="post" >
            <input name="user_name" type="text" class="form-control" placeholder="Votre Nom" required>
            <br>
            <input name="email" type="email" class="form-control" placeholder="Votre Email" required>
            <br>
            <textarea name="message" class="form-control" placeholder="Message" rows="5" required></textarea>
            <br>
            <input type="submit" class="form-control submit" value="ENVOYER MESSAGE" name="envoyer" onclick='window.location.reload(false)'>
            
            
            
        </form>
    </div>
    </main>
	
    <?php 
if(isset($_POST['envoyer']))
{
    if(empty($_POST['email'])||empty($_POST['user_name'])||empty($_POST['message']))
    {
        echo "Veuillez remplir tous les champs !!";
    }
    else{
        $fp = fopen("info.txt","a+");
        
        fputs($fp, "Nom : ");
        fputs($fp, stripslashes($_POST['user_name']));

        fputs($fp, "\nMail : ");
        fputs($fp, stripslashes($_POST['email']));

        fputs($fp, "\nMessage : ");
        fputs($fp, stripslashes($_POST['message']));
       
        fputs($fp,"\n---------------------------------------------\n");

        fclose($fp);
       }
}

?>
<?php require($_SERVER['DOCUMENT_ROOT']."/vues/Footers/footer.php");?>

