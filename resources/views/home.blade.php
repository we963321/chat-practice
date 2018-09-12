@extends('layouts.app')
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <input type="text" name="message" value="">
                <button onclick="sendMessage()" id="send">send</button>
            </div>
            <div class="messages" style="max-height:500px;overflow-y:auto"></div>
        </div>
    </div>
</div>
<script>
    
    const user = "{{ Auth::user()->name }}";
    const title = document.title;

    function sendMessage(){
        if($("input[name=message]").val().trim() === ''){
            return false;
        }
        let message = $("input[name=message]").val();
        let data = {'message' : message};
        axios.post('/sendMessage', data).then(response => {
            $("input[name=message]").val('');
        });

        let div = document.querySelector('.messages');
    }

    function reviewMessage(target){
        let currentDate = new Date();
        let nowTime = currentDate.getFullYear()+'-'+Number(currentDate.getMonth()+1)+'-'+currentDate.getDate()+'\n'+currentDate.getHours()+':'+currentDate.getMinutes()+':'+currentDate.getSeconds();
        let str = `<div style="padding:5px">${target.name.name}\n:\n${target.message}<br>${nowTime}</div>`;
        $('.messages').append(str);

        if(user != target.name.name){
            titleBlink();
        }
    }

    let record = 0;
    let timer = 0;

    function titleBlink(){
        record++;
        if(record == 3){
            record = 1;
        }
        if(record == 1){
            document.title = '【  】' + title;
        }
        if(record == 2){
            document.title = '【新消息】' + title;
        }
        if(timer == 0){
            timer = setInterval("titleBlink()", 800);
        }
    }

    function resetTitle(){
        clearInterval(timer);
        document.title = title;
    }

    document.onkeydown = function (event) {
        if (event.keyCode == 13) {
            $("#send").trigger("click");
        }
    };

    let messageDiv = document.querySelector('.messages');
    document.body.addEventListener('click', function(){
        resetTitle();
        messageDiv.scrollTop = messageDiv.scrollHeight;
    });

</script>
@endsection
