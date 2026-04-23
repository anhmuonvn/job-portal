@extends('front.layouts.app')
@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Đăng Kí*</h1>
                    <form action="" id="registrationForm" name="registrationForm">
                        <div class="mb-3">
                            <label for="" class="mb-2">Tên*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Mật khẩu*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Xác nhận mật khẩu*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label>Bạn là? *</label><br>

                            <input type="radio" name="role" value="candidate" checked required>
                            Ứng viên

                            <input type="radio" name="role" value="employer">
                            Nhà tuyển dụng
                        </div> 
                        <button class="btn btn-primary mt-2">Đăng kí</button>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Bạn có tài khoản chưa? <a  href="{{ route('account.login') }}">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
     $('#registrationForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'{{ route("account.store") }}',
            type:'post',
            data:$('#registrationForm').serializeArray(),
            dataType:'json',
            success:function(res){
                if(res.status===false)
                {
                    var errors = res.errors;
                    if(errors.name)
                    {
                        $('#name').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.name)
                                                
                    }
                    else
                    {
                        $('#name').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.email)
                    {
                        $('#email').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.email)
                                                
                    }
                    else
                    {
                        $('#email').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.password)
                    {
                        $('#password').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.password)
                                                
                    }
                    else
                    {
                        $('#password').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    }
                    if(errors.confirm_password)
                    {
                        $('#confirm_password').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.confirm_password)
                                                
                    }
                    else
                    {
                        $('#confirm_password').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }

                }
                else
                {
                    $('#name').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#email').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('') 
                    $('#password').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#confirm_password').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    window.location.href = "{{ route('account.login') }}";                                               
                }
                
            }

        })
     })
</script>
@endsection