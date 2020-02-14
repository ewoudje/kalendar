<!DOCTYPE html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <title>UI color picker</title>
    <script src="lib/ckeditor_4.13/ckeditor/ckeditor.js"></script>
</head>

<body>
    <textarea id="editor1"></textarea>
    <script>
	CKEDITOR.replace( 'editor1', '' );
    </script>
    
    <form action="sendmail.php" method="POST" >
        <input type="hidden" id="text" name="data" />
        <input type="submit" id="verder" value="Verder" onclick="myFunction()">
    </form>
    
</body>

<script>
    function myFunction(){
        var data = CKEDITOR.instances.editor1.getData();
        document.getElementById("text").value = data;
        // Your code to save "data", usually through Ajax.
    }
</script>

</html>

</html>
