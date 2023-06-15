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



                const pusher = new Pusher('b5b8c97866eb51c4c2c7', {
                cluster: 'ap2',
                });

                // Subscribe to the dynamic channel
                var channel = pusher.subscribe('recommendation.plan2');
                console.log(channel);
                // Listen for events on the channel
                channel.bind('recommendation.plan', function (data) {
                console.log('Received recommendation event:', data);
                // Handle the received event data here

                });

                var channel = pusher.subscribe('chat.plan1');
                console.log(channel);
                // Listen for events on the channel
                channel.bind('chat.plan1', function (data) {
                console.log('Received recommendation event:', data);
                // Handle the received event data here
                });







// var x="plan1";
// // console.log('recommendation/'+x);
//     window.Echo.channel('recommendation')
//     .listen('.recommendation/'+x,(e)=>{
//        console.log(e);
//     });

// //chat

//     window.Echo.channel('ChatPlan')
//     .listen('.ChatPlan',(e)=>{
// console.log(e);
//         var result = e.Massage.original.massage.massage;
//         var resultText = document.createTextNode(result);

//         var resultDiv = document.getElementById("resultDiv");
//        resultDiv.appendChild(resultText);
//     });




  </script>



{{-- <img src="{{ asset('media/1686748028_images.jpg') }}" alt=""> --}}


</body>
</html>


{{-- connectChannel({required String channelName,required dynamic onEvent}) async {
    debugPrint("connectChannel $channelName");

    await _pusher.subscribe(
      channelName: channelName,

      onEvent: onEvent,
      onSubscriptionSucceeded: (data) {
        debugPrint("success Connecting $channelName channel: ${data.toString()}");
      },
      onSubscriptionError: (error) {
        debugPrint("error: ${error.message}");
      },
    );
  } --}}
