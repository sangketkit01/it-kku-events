@extends('layout')
@section('title',"Vote")
@push('style')
    <link rel="stylesheet" href="/CSS/vote.css">
@endpush

@section('content')
    <img src="/index/poster3.png" alt="" id="poster">
    <h1 id="vote-header">ร่วมโหวต{{$header}} IT</h1>
    <div class="count">
        <div class="countdown"><span id="days"></span>Days</div>
        <div class="countdown"><span id="hours"></span>Hours</div>
        <div class="countdown"><span id="minutes"></span>Minutes</div>
        <div class="countdown"><span id="seconds"></span>Seconds</div>
    </div>

    <div class="podium">
        <div class="second-place">
             @if(isset($return_data[1]))
                <img src="{{explode(',',$return_data[1]->image_path)[0]}}" class="shirt" alt="">
            @endif   

            <div class="place" id="second">
                <img src="/index/silver.png" alt="">
                @if(isset($score[1]))
                 <label for="" id="podium-score">{{$score[1]}}</label>
                  <label for="" id="podium-under-score">คะแนน</label>
                @endif
            </div>
        </div>
        <div class="first-place">
            @if(isset($return_data[0]))
                <img src="{{explode(',',$return_data[0]->image_path)[0]}}" class="shirt" alt="">
            @endif    
            <div class="place" id="first">
                 <img src="/index/gold.png" alt="">
                 @if(isset($score[0]))
                 <label for="" id="podium-score">{{$score[0]}}</label>
                  <label for="" id="podium-under-score">คะแนน</label>
                @endif
            </div>
        </div>
        <div class="third-place" >
             @if(isset($return_data[2]))
                <img src="{{explode(',',$return_data[2]->image_path)[0]}}" class="shirt" alt="">
            @endif   
            <div class="place" id="third">
                <img src="/index/bronze.png" alt="">
                 @if(isset($score[2]))
                 <label for="" id="podium-score">{{$score[2]}}</label>
                 <label for="" id="podium-under-score">คะแนน</label>
                @endif
            </div>
        </div>
    </div>

    <div class="vote">
        <a id="vote-button" href="/vote/{{$event}}/list">ร่วมโหวต</a>
    </div>

    <div class="score-board">

        @foreach ($score_board as $item) 
        <div class="score-content">
            <img src="{{explode(',',$item[0]->image_path)[0]}}" alt="" class="shirt-picture">
            <label for="" id="shirt-name">{{$item[0]->name}}</label>
            <label for="" id="shirt-score">{{$item[1]}}</label>
        </div>
        @endforeach
        
    </div>
    

    <script>
        const second = 1000;
        const minute = second * 60;
        const hour = minute * 60;
        const day = hour * 24;

        function countDown() {
            const now = new Date().getTime();
            const deadline = new Date("July 15, 2024 23:59:59").getTime();
            const unixTimeLeft = deadline - now;

            const dayElement = document.getElementById("days");
            dayElement.innerText = Math.floor(unixTimeLeft / day);

            const hourElement = document.getElementById("hours");
            hourElement.innerText = Math.floor((unixTimeLeft % day) / hour);

            const minuteElement = document.getElementById("minutes");
            minuteElement.innerText = Math.floor((unixTimeLeft % hour) / minute);

            const secondElement = document.getElementById("seconds");
            secondElement.innerText = Math.floor((unixTimeLeft % minute) / second);
        }    
            function run(){
                countDown();
                setInterval(countDown,second);
            }

            run();
    </script>
@endsection
