<DOCTYPE html>
<html lang="ru">
    <head>
       	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    </head>
    <body>
        <form id="Letters" method="post">
            <button name = "1">А</button>
            <button name = "2">Б</button>
            <button name = "3">В</button>
            <button name = "4">Г</button>
            <button name = "5">Д</button>
            <button name = "6">Е</button>
            <button name = "7">Ё</button>
            <button name = "8">Ж</button>
            <button name = "9">З</button>
            <button name = "10">И</button>
            <button name = "11">Й</button>
            <button name = "12">К</button>
            <button name = "13">Л</button>
            <button name = "14">М</button>
            <button name = "15">Н</button>
            <button name = "16">О</button>
            <button name = "17">П</button>
            <button name = "18">Р</button>
            <button name = "19">С</button>
            <button name = "20">Т</button>
            <button name = "21">У</button>
            <button name = "22">Ф</button>
            <button name = "23">Х</button>
            <button name = "24">Ц</button>
            <button name = "25">Ч</button>
            <button name = "26">Ш</button>
            <button name = "27">Щ</button>
            <button name = "28">Ъ</button>
            <button name = "28">Ы</button>
            <button name = "29">Ь</button>
            <button name = "30">Э</button>
            <button name = "31">Ю</button>
            <button name = "32">Я</button>
        </form>

        <div class="mess"></div>

        <script type="text/javascript">
        $('#Letters').submit(function(e) {
            e.preventDefault();
            let m = $('.mess');
            let form = $(this);
            $.ajax({
                type: "POST",
                url: '/protected/script.php',
                data: form.serialize(),
                success: function(data)
                {
                    if (data == false)
                    {
                        m.html('нет такой буквы');
                        return false;    
                    }
                    m.html('есть такая буква');
                    return true;
                }//, 
                /*error: function()
                {
                    m.html('error');
                }*/
            });
        });
        </script>
    </body>
</html>