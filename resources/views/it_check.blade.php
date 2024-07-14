@extends('layout')
@section('title',"IT Check")
@push('style')
    <link rel="stylesheet" href="/CSS/check.css">
@endpush

@section('content')

  
    <div class="content">
        <label for="" id="header">ยืนยันตัวตน</label>
        <form action="/it/check/{{Session::get("user_email")}}" method="POST">
            @csrf
            <div class="std_id">
                <label for="">รหัสนักศึกษา:</label>
                <input type="text" placeholder="รหัสนักศึกษามีขีด" id="id-field" required name="id">
            </div>
            <input type="submit" value="ยืนยัน" id="submit">
        </form>
    </div>

    @if(isset($is_brat) && $is_brat)
        <script>
            let container = document.querySelector('.container');
            console.log({{$is_it}})
            while (container.firstChild) {
                container.removeChild(container.firstChild);
            }
            document.querySelector('.content').style.height = "220px";
        </script>
        <div class="content" style="height: 220px">
            <label for="" id="line1">ขออภัย!</label>
            <label for="" id="line2">มีผู้ยืนยันตัวตนด้วย<span style="color: #FF0000">รหัสนี้</span>แล้ว</label> 
            <button id="ok-blue" class="new-button" onclick="window.location.href='/check'">OK</button>
        </div>
    @elseif (isset($is_it) && $is_it == true)
         <script>
            let container = document.querySelector('.container');
            console.log({{$is_it}})
            while (container.firstChild) {
                container.removeChild(container.firstChild);
            }
            document.querySelector('.content').style.height = "220px";
        </script>
        <div class="content" style="height: 220px">
            <label for="" id="line1">ยินดีต้อนรับ!</label>
            <label for="" id="line2">คุณคือเด็ก<span id="it" style="color: #0066FF;">ไอที</span>ตัวจริง</label>  
            <button id="ok-blue" class="new-button" onclick="window.location.href='/'">OK</button>
        </div>
    @elseif(isset($is_it) && $is_it == false)
         <script>
            let container = document.querySelector('.container');
            while (container.firstChild) {
                container.removeChild(container.firstChild);
            }
            document.addEventListener('DOMContentLoaded',()=>{
                let content = document.querySelector('.content');
                content.style.height = "220px";
            })
        </script>
        <div class="content" style="height: 220px">
            <label for="" id="line1">ขออภัย!</label>
            <label for="" id="line2">คุณ<span id="it" style="color: #FF0000;">ไม่มีสิทธิ์</span>ใช้งาน</label> 
            <div class="buttons">
                <button id="ok-blue" class="new-button" onclick="window.location.href='/again'">กรอกรหัสใหม่</button>
                <button id="ok-red" class="new-button" onclick="window.location.href='/'">เยี่ยมชม</button>
            </div> 
        </div>
    @endif

@endsection