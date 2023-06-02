<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <!-- Bootstrap CSS -->

    @vite(['resources/js/app.js'])
</head>
<body>



  <script type="module" >
    window.Echo.channel('recommendation')
    .listen('.recommendation',(e)=>{
       console.log(e);
    });
  </script>



<img src="{{ asset('Recommendation/1684590261.jpg') }}" alt="">


</body>
</html>
