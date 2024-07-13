<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In</title>
    <link rel="stylesheet" href="/CSS/sign_in.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="form-login">
            <form action="" method="post">
                @csrf
                <div class="header">
                    <label for="" id="event">Event</label>
                    <label for="" id="it-kku">IT KKU</label>
                    <label for="" id="it-full">Information Technology Events</label>
                </div>
                <a href="{{route('google-auth')}}" type="button" id="kku-login"><img src="/login/kku-logo.png" alt="">ล็อคอินด้วยบัญชี KKU-Mail</a>
                <div class="or">
                    <div class="line"></div>
                    <label for="" id="or-text">หรือ</label>
                    <div class="line"></div>
                </div>
                <input class="input" id="email" type="email" name="email" placeholder="อีเมลล์" required>
                <input class="input" id="password" type="password" name="password" placeholder="รหัสผ่าน" required>
                <a href="" id="forgot-pass">ลืมรหัสผ่าน?</a>
                <a href="" id="invalid">Invalid e-mail or password </a>
                <button type="submit"  id="login-button">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>

    @if (session()->has('not_kku'))
        <script>
            let not_kku = document.querySelector('#invalid');
            not_kku.innerText = "โปรดล็อคอินด้วยบัญชี KKU Mail"
            not_kku.style.display = 'block'
        </script>
    @elseif(session()->has('oops'))
        <script>
            let oops = document.querySelector('#invalid');
            oops.innerText = "ฮั่นแน่! อย่าเปรี้ยว ล็อกอินก่อนเนาะ"
            oops.style.display = 'block'
        </script>
    @endif

    <script>
        let inputs = document.querySelectorAll('.input');
        let email = document.querySelector('#email');
        let password = document.querySelector('#password');
        let invalid = document.querySelector('#invalid');
        document.querySelector('#login-button').addEventListener('click', function(event){
            event.preventDefault();
            inputs.forEach(input => {
                if(input.value === ""){
                    Swal.fire({
                        icon: "question",
                        title: "ทำอะไร ใส่ข้อมูลให้ครบสิ",
                       
                    });
                    invalid.style.display = 'none'
                }else{
                    invalid.innerText = 'Invalid Email or Password'
                    invalid.querySelector('#invalid').style.display = "block"
                }

            })
            if(document.querySelector('#invalid').style.display === 'block'){
                email.value = "";
                password.value = "";
            }
        });

        document.querySelector('#forgot-pass').addEventListener('click',(event)=>{
            event.preventDefault()
            Swal.fire({
                icon : "error",
                "title" : "โดนหลอกแล้วไง"
            })
        })

        
    </script>

</body>
</html>