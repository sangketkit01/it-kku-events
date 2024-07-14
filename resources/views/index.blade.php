@extends('layout')
@section('title', 'Home')
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

        <div class="events" id="shirt-event">
            <img src="/index/shirt-poster.png" alt="">
            <div class="detail">
                <div class="date">
                    <p>July</p>
                    <label for="">16</label>
                </div>
                <div class="event-detail">
                    <label>กิจกรรมออกแบบเสื้อเชิ๊ต</label>
                    <p>กิจกรรมโหวตเสื้อเพื่อนำมาใช้ในการจัดทำเสื้อสาขาของหลักสูตรเทคโนโลยีสารสนเทศ</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const now = new Date().getTime();
        const logo_open = new Date("July 11, 2024 06:00:00").getTime();
        const logo_close = new Date("July 14, 2024 23:59:59").getTime();
        const shirt_open = new Date("July 15 2024 01:00:00").getTime();
        const shirt_close = new Date("July 15 2024 23:59:59").getTime();

        let logo_event = document.querySelector('#logo-event')
        let shirt_event = document.querySelector('#shirt-event')

        logo_event.addEventListener('click', () => {
            window.location.href = '/vote/logo';
        })

        if (now < logo_open || now > logo_close) {
            logo_event.classList.add('not-open');
        } else {
            logo_event.classList.remove('not-open')
        }

        shirt_event.addEventListener('click', () => {
            window.location.href = '/vote/shirt';

        })

        if (shirt_open > now || shirt_close < now) {
            shirt_event.classList.add('not-open');
        } else {
            shirt_event.classList.remove('not-open')
        }
    </script>
@endsection
