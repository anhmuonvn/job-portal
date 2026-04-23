@extends('front.layouts.app')
@section('main')
   <section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Cài đặt hệ thống</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.alert')
                <div class="card border-0 shadow mb-4">
                    <form action="" method="post" id="userForm" name="userForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body  p-4">
                            <h3 class="fs-4 mb-1">Hồ sơ của tôi</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Tên*</label>
                                <input type="text" placeholder="Enter Name" name="name" id="name" class="form-control" value="{{ $user->name }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" placeholder="Enter Email" name="email" id="email" class="form-control"
                                value="{{ $user->email }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Chức danh</label>
                                {{-- <input type="text" name="designation" id="designation" placeholder="Enter Designation"  class="form-control"  value="{{ $user->designation }}"> --}}
                                <select name="designation" id="designation" class="form-control">
                                        <option value="">Chọn chức danh</option>
                                        <option value="Web Developer" {{ $user->designation == 'Web Developer' ? 'selected' : '' }}>Web Developer</option>
                                        <option value="Mobile Developer" {{ $user->designation == 'Mobile Developer' ? 'selected' : '' }}>Mobile Developer</option>
                                        <option value="Graphic Designer" {{ $user->designation == 'Graphic Designer' ? 'selected' : '' }}>Graphic Designer</option>
                                        <option value="Project Manager" {{ $user->designation == 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
                                        <option value="Data Analyst" {{ $user->designation == 'Data Analyst' ? 'selected' : '' }}>Data Analyst</option>
                                                        
                                </select>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Điện thoại*</label>
                                <input type="text" name="mobile" id="mobile" placeholder="Mobile"  class="form-control"  value="{{ $user->mobile }}">
                               
                                <p></p>
                            </div>  
                            <div class="mb-4">
                                <label for="" class="mb-2">Mô tả ngắn</label>
                                <textarea class="form-control" style="height: 200px" name="summary" id="summary" rows="5" cols="5">{{ $user->summary }}</textarea>
                                <p></p>
                               
                                
                            </div> 
                            @if($user->cv)
                            <div class="mb-3">
                                <label class="mb-2">CV của tôi:</label><br>
                                <a href="{{ asset('uploads/cv/'.$user->cv) }}" target="_blank">
                                    Xem CV
                                </a>
                            </div>
                            @endif 
                            <div class="mb-4">
                                <label for="" class="mb-2">CV của bạn</label>
                                <input type="file" name="cv" id="cv" placeholder="cv"  class="form-control"  >
                               
                                <p></p>
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>

                {{-- <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password*</label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>                 --}}
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
  <script >
     function handleError(field,error){
        if(error){
            $('#'+field).addClass('is-invalid')
                        .siblings('p').addClass('invalid-feedback')
                        .html(error)
        }
        else
        {
            $('#'+field).removeClass('is-invalid')
                        .siblings('p').removeClass('invalid-feedback')
                        .html('')
        }
     }
     $('#userForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this)
        $.ajax({
            url:'{{ route("account.updateProfile") }}',
            type:'post',
            data:formData,
            dataType:'json',
            contentType:false,
            processData:false,
            success:function(res){
                if(res.status===false)
                {
                    var errors = res.errors;
                    handleError('name',errors.name);
                    handleError('email',errors.email);
                    handleError('designation',errors.designation);
                    handleError('mobile',errors.mobile);
                    handleError('summary',errors.summary);
                    handleError('cv',errors.cv);
                    

                }
                else
                {
                    
                    window.location.href = "{{ route('account.profile') }}";                                               
                }
                
            }

        })
     })
</script>
@endsection