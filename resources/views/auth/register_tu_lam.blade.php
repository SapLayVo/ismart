@extends('layouts.app')

@section('content')
<div class="center">
    <h1>Đăng ký</h1>
    <form action="#" method="POST" >
        <div class="txt_field">
            <input type="text" name="name" required>
            <span></span>
            <label for="username">Họ và tên</label>
        </div>
        <div class="txt_field">
            <input type="mail" name="mail" required>
            <span></span>
            <label for="mail">Email</label>
        </div>
        <div class="txt_field">
            <input type="password" name="name" required>
            <span></span>
            <label for="password">Mật khẩu</label>
        </div>
        <div class="txt_field">
            <input type="password" name="re_pass" required>
            <span></span>
            <label for="re_pass">Nhập lại mật khẩu</label>
        </div>
        <!-- <div class="pass">Quên mật khẩu?</div> -->
        <input type="submit" value="Đăng ký">
        <div class="reg_link">
             <a href="#">Đăng nhập</a>
        </div>
    </form>
</div>
@endsection