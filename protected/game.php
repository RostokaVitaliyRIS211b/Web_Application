<DOCTYPE html>
<html>
    <head>
       	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    </head>
    <body>
        <form id="Letters" method="post">
            <button name ="А">А</button>
            <button name ="Б">Б</button>
            <button name ="В">В</button>
            <button name ="Г">Г</button>
            <button name ="Е">Е</button>
            <button name ="Ё">Ё</button>
            <button name ="Ж">Ж</button>
            <button name ="З">З</button>
            <button name ="И">И</button>
            <button name ="Й">Й</button>
            <button name ="К">К</button>
            <button name ="Л">Л</button>
            <button name ="М">М</button>
            <button name ="Н">Н</button>
            <button name ="О">О</button>
            <button name ="П">П</button>
            <button name ="Р">A</button>
            <button name ="С">С</button>
            <button name ="Т">Т</button>
            <button name ="У">У</button>
            <button name ="Ф">Ф</button>
            <button name ="Х">Х</button>
            <button name ="Ц">Ц</button>
            <button name ="Ч">Ч</button>
            <button name ="Ш">Ш</button>
            <button name ="Щ">Щ</button>
            <button name ="Ъ">Ъ</button>
            <button name ="Ы">Ы</button>
            <button name ="Ь">Ь</button>
            <button name ="Э">Э</button>
            <button name ="Ю">Ю</button>
            <button name ="Я">Я</button>
        </form>
        <script type="text/javascript">
        $(document).ready(function() {
    		$('#Letters').submit(function(e) {
        		e.preventDefault();
        		$.ajax({
            		type: "POST",
            		url: '',
            		data: $(this).serialize(),
            		success: function(response)
            		{
            			//pass
            		}
       			});
     		});
        });
        </script>
    </body>
</html>