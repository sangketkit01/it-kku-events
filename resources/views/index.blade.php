@extends('layout')
@section('title',"Home")
@push('style')
    <link rel="stylesheet" href="/CSS/index.css">
@endpush

@section('content')
    <div class="head">
        <h1>IT KKU EVENT</h1>
        <label for="">Information Technology Events</label>
        <div class="search">
            <div class="event">
                <p>Search Event</p>
                <input type="text">
            </div>
            <div class="place">
                <p>Place</p>
                <input type="text">
            </div>
            <div class="Time">
                <p>Time</p>
                <input type="date">
            </div>
        </div>
    </div>

    <div class="content-header">
        <div class="content-header-content">
            <h1>Upcoming Events</h1>
            <div class="select">
                <select name="" id="">
                    <option value="">Day</option>
                    <option value="">Monday</option>
                    <option value="">Tuesday</option>
                    <option value="">Wednesday</option>
                    <option value="">Thursday</option>
                    <option value="">Firday</option>
                    <option value="">Saturday</option>
                    <option value="">Sunday</option>
                </select>
                <select name="" id="">
                    <option value="">Place</option>
                    <option value="">On-site</option>
                    <option value="">Online</option>
                </select>
            </div>
        </div>
    </div>

    <div class="event-content">
        <div class="events" id="logo-event">
            <img src="/index/poster2.png" alt="">
            <div class="detail">
                <div class="date">
                    <p>July</p>
                    <label for="">10</label>
                </div>
                <div class="event-detail">
                    <label>กิจกรรมโหวตโลโก้สาขา</label>
                    <p>กิจกรรมโหวตโลโก้สาขาเพื่อนำมาใช้ในการจัดทำเสื้อสาขา ของหลักสูตรเทคโนโลยีสารสนเทศ</p>
                </div>
            </div>
        </div>

         <div class="events" id="shirt-event" style="display: none">
            <img src="/index/logo-poster.png" alt="">
            <div class="detail">
                <div class="date">
                    <p>July</p>
                    <label for="">16</label>
                </div>
                <div class="event-detail">
                    <label>กิจกรรมออกแบบเสื้อเชิ๊ต</label>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime ad perspiciatis repellendus ipsa,
                         unde assumenda doloribus delectu</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const now = new Date().getTime();
        const logo_open = new Date("July 9, 2024 06:00:00").getTime();
        let logo_deadline = logo_open - now;
        console.log(logo_deadline);

        let logo_event = document.querySelector('#logo-event')
        logo_event.addEventListener('click',()=>{
            window.location.href = '/vote/logo';
        })

        if(logo_deadline > 0){
            logo_event.classList.add('not-open');
        }else{
            logo_event.classList.remove('not-open')
        }

         document.querySelector('#shirt-event').addEventListener('click',()=>{
            window.location.href = '/vote/shirt';
            
        })
    </script>
@endsection