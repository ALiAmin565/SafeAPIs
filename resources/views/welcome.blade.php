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


    <div id="resultDiv">
        {{-- @foreach ($collection as $item)
           <h6> {{ $item->massage }}</h6>
         @endforeach --}}
    </div>











  <script type="module" >
var resultDiv = document.getElementById("resultDiv");



    window.Echo.channel('recommendation'+plan_name)
    .listen('.recommendation',(e)=>{
       console.log(e);
    });

//chat

    window.Echo.channel('ChatPlan')
    .listen('.ChatPlan',(e)=>{
console.log(e);
        var result = e.Massage.original.massage.massage;
        var resultText = document.createTextNode(result);

        var resultDiv = document.getElementById("resultDiv");
       resultDiv.appendChild(resultText);
    });




  </script>



{{-- <img src="{{ asset('Recommendation/1684590261.jpg') }}" alt=""> --}}


</body>
</html>
