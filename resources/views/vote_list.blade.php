@extends('layout')
@section('title',"Vote List")
@push('style')
    <link rel="stylesheet" href="/CSS/vote_list.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <hr>
    <h1>กิจกรรมโหวต{{$header}} IT</h1>
    <div class="cards">
        @foreach ($data as $item) 
        <div class="content">
            <img src="{{explode(',',$item->image_path)[0]}}" class="images" alt="">
            <div class="detail">
                <table>
                    <tr>
                        <th>ชื่อผลงาน:</th>
                        <td>{{$item->name}}</td>
                    </tr>
                    <tr>
                        <th>รายละเอียด:</th>
                        <td class="text-detail">{{$item->detail}}</td>
                    </tr>
                    <tr>
                        <th>ผู้ออกแบบ:</th>
                        <td>{{$item->designer}}</td>
                    </tr>
                </table>
                <button class="more-button" onclick="window.location.href='/vote/{{$event}}/detail/{{$item->id}}'">รายละเอียดเพิ่มเติม</button>
            </div>
        </div>
        @endforeach
    </div>

@endsection
