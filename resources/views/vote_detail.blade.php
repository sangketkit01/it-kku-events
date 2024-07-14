@extends('layout')
@section('title', 'Detail')
@push('style')
    <link rel="stylesheet" href="/CSS/vote_detail.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('content')
    <div class="content">
        <div class="image-slider">
            <button><img src="/index/left-button.png" id="previousPicture" alt=""></button>
            <div class="images">
                @php
                    $commaPosition = strpos($data->image_path, ',');
                @endphp

                @if ($commaPosition !== false)
                    @foreach (explode(',', $data->image_path) as $item)
                        <img src="{{ $item }}" id="image" class="imageSlider" alt="">
                    @endforeach
                @else
                    <img src="{{ $data->image_path }}" id="image" alt="">
                @endif
            </div>
            <button><img src="/index/right-button.png" id="nextPicture" alt=""></button>
        </div>


        <div class="shirt-detail">
            <div class="detail">
                <h1 class="header">{{ $data->name }}</h1>
                <p class="detail-text">{{ $data->detail }}</p>
            </div>
            @if (isset($event) && $event == 'shirt')
                <div class="colors">
                    <input type="radio" id="color1" name="color" value="25295A" onchange="getSelectedColor()">
                    <label for="color1" id="color1"></label>

                    <input type="radio" id="color2" name="color" value="1E3874" onchange="getSelectedColor()">
                    <label for="color2" id="color2"></label>

                    <input type="radio" id="color3" name="color" value="1D3D75" onchange="getSelectedColor()">
                    <label for="color3" id="color3"></label>
                </div>
            @endif

            <div class="score-detail">
                <label for="">คะแนน {{ $vote->count }} โหวต</label>
                <div>
                    <button class="vote-button">โหวต</button>

                </div>
            </div>
        </div>
    </div>

    @if ($commaPosition === false)
        <style>
            #previousPicture,
            #nextPicture {
                display: none;
            }
        </style>
    @endif

    @if (Session::get('is_it') == 0)
        <script>
            let voteButton = document.querySelector('.vote-button');
            voteButton.innerText = 'คุณไม่มีสิทธิ์โหวต'
            voteButton.style.cursor = 'default';
            voteButton.style.backgroundColor = 'gray'
            voteButton.disabled = true
            voteButton.style.fontSize = '30px'
        </script>
    @elseif($is_vote)
        <script>
            let voteButton = document.querySelector('.vote-button');
            voteButton.innerText = 'คุณโหวตไปแล้ว'
            voteButton.style.cursor = 'default';
            voteButton.style.backgroundColor = 'gray'
            voteButton.disabled = true
            voteButton.style.fontSize = '1.5em'
        </script>
    @endif

    @if (isset($event) && $event == 'shirt')
        <script>
            color = " ";

            function getSelectedColor() {
                const selectedColor = document.querySelector('input[name="color"]:checked');
                if (selectedColor) {
                    color = selectedColor.value;
                }
            }


            function vote() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success me-3 ps-4 pe-4",
                        cancelButton: "btn btn-secondary ps-3 pe-3"
                    },
                    buttonsStyling: false
                });

                if (color === " ") {
                    swalWithBootstrapButtons.fire({
                        title: "กรุณาเลือกสีเสื้อ",
                        icon: "error",
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: "OK"
                    })
                } else {
                    swalWithBootstrapButtons.fire({
                        title: "คุณยืนยันที่จะโหวต {{ $data->name }}?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "ใช่",
                        cancelButtonText: "ไม่ใช่",
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "คุณได้โหวต{{ $header }}แล้ว",
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(() => {
                                window.location.href = '/vote/{{ $event }}/{{ $id }}/check' +
                                    `/${color}`
                            });
                        }
                    });
                }

            }
            document.querySelector('.vote-button').addEventListener('click', vote);
        </script>
    @elseif(isset($event) && $event == 'logo')
        <script>
            function vote() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success me-3 ps-4 pe-4",
                        cancelButton: "btn btn-secondary ps-3 pe-3"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "คุณยืนยันที่จะโหวต {{ $data->name }}?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "ใช่",
                    cancelButtonText: "ไม่ใช่",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "คุณได้โหวต{{ $header }}แล้ว",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            window.location.href = '/vote/{{ $event }}/{{ $id }}/check/logo'
                
                        });
                    }
                });
            }

            document.querySelector('.vote-button').addEventListener('click', vote);
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let detailText = document.querySelector('.detail-text');
            let header = document.querySelector('.header');

            if (detailText && detailText.textContent.length > 500) {
                let detailFontSize = window.getComputedStyle(detailText, null).getPropertyValue('font-size');
                let newDetailFontSize = (parseFloat(detailFontSize) - 5) + 'px';
                detailText.style.fontSize = newDetailFontSize;

                let headerFontSize = window.getComputedStyle(header, null).getPropertyValue('font-size');
                let newHeaderFontSize = (parseFloat(headerFontSize) - 10) + 'px';
                header.style.fontSize = newHeaderFontSize;
            }

            let index = 0;
            let pictures = document.querySelectorAll('.imageSlider');
            if (index == 0) {
                pictures[index].classList.remove('imageSlider')
            }

            document.querySelector('#previousPicture').addEventListener('click', () => {
                pictures[index].style.animation = 'removeCurrentToPrevious 0.4s ease-out'
                pictures[index].classList.add('imageSlider')

                index--;
                if (index < 0) {
                    index = pictures.length - 1;
                }

                pictures[index].classList.remove('imageSlider')
                pictures[index].style.animation = 'previousPicture 0.3s ease-in'
            })

            document.querySelector('#nextPicture').addEventListener('click', () => {
                pictures[index].style.animation = 'removeCurrentToNext 0.4s ease-out'
                pictures[index].classList.add('imageSlider');
                index++;
                if (index >= pictures.length) {
                    index = 0;
                }
                pictures[index].classList.remove('imageSlider')
                pictures[index].style.animation = 'nextPicture 0.3s ease-in'

            })
        });
    </script>
@endsection
