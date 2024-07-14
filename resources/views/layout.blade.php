<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/CSS/layout.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('style')
    </head>

    <body>
        <div class="nav">
            <a href="/" class="left"><img src="/nav/kku-logo.png" alt="" /></a>
            <div class="h-line"></div>
            <a href="/" class="left"><img src="/nav/it-logo.svg" alt="" /></a>

            <div class="right">
                <a href="/" id="home">หน้าแรก</a>
                <a><img src="{{Session::get('avatar')}}" id="user-logo" alt=""/></a>
                <div class="dropdown">
                    <button id="down_arrow">
                        <img src="/nav/down_arrow.png" alt="" />
                    </button>
                    <div class="dropdown_list">
                        <a href="{{ route('sign_in') }}" id="dropdown_item1">{{ __('เข้าสู่ระบบ') }}</a>
                    </div>
                </div>
            </div>

            @if (Session::get('user'))
            <script>
                let dropdown = document.querySelector(".dropdown_list");
                let hello = document.createElement("a");

                hello.id = "dropdown_item2";
                hello.innerText = `สวัสดี {{Session::get('name')}}`;
                dropdown.prepend(hello);
                hello.addEventListener('click',(event)=>{
                    event.preventDefault();
                    
                    Swal.fire({
                        icon : "question",
                        title : "กดทำไมครับ มันไม่มีไร"
                    })
                })


                let dropdown1 = document.querySelector("#dropdown_item1");
                dropdown1.innerText = "ออกจากระบบ";
                dropdown1.href = "{{route('sign_out')}}";
            </script>
            @endif
        </div>

        <div class="container">
            @yield('content')
        </div>
    </body>
    <script>
        let down_arrow_button = document.querySelector("#down_arrow");
        let dropdown_list = document.querySelector(".dropdown_list");

        down_arrow_button.addEventListener("click", (event) => {
            event.stopPropagation(); 
            if (dropdown_list.style.display === "none" ||dropdown_list.style.display === ""){
                dropdown_list.style.display = "block";
            } else {
                dropdown_list.style.display = "none";
            }
        });

        document.addEventListener("click", (event) => {
            if (!dropdown_list.contains(event.target) &&event.target !== down_arrow_button) {
                dropdown_list.style.display = "none";
            }
        });

        
    </script>
</html>
