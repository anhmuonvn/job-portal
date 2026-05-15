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
                    <form action="" id="companyForm" name="companyForm" >
                        @csrf
                        <div class="card-body  p-4">
                            <h3 class="fs-4 mb-1">Thông tin công ty</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Tên công ty*</label>
                                <input type="text" placeholder="Enter company name" name="company_name" id="company_name" class="form-control" value="{{ $company->company_name }}">
                                <p></p>
                            </div>
                            
                            <div class="mb-4">
                                <label for="" class="mb-2">Tỉnh/Thành Phố</label>
                                {{-- <input type="text" name="designation" id="designation" placeholder="Enter Designation"  class="form-control"  value="{{ $user->designation }}"> --}}
                                <select name="company_location" id="company_location" class="form-control">
                                        <option value="">Chọn tỉnh/thành phố </option>
                                        @if($locations->isNotEmpty())
                                            @foreach ($locations as $location)
                                                <option {{ ($company->location_id == $location->id) ? 'selected' : '' }} value="{{$location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        @endif
                                                        
                                </select>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Website*</label>
                                <input type="text" name="company_website" id="company_website" placeholder="Website"  class="form-control"  value="{{ $company->company_website }}">
                               
                                <p></p>
                            </div> 
                            <div class="mb-4">
                                <label for="" class="mb-2">Địa chỉ trụ sở</label>
                                <input type="text" name="company_address" id="company_address" placeholder="Company Address"  class="form-control"  value="{{ $company->company_address }}">
                               
                                <p></p>
                            </div>  
                            <div class="mb-4">
                                <label for="" class="mb-2">Mô tả </label>
                                <textarea class="form-control" style="height: 200px" name="company_description" id="company_description" rows="5" cols="5">{{ $company->company_description }}</textarea>
                                <p></p>
                               
                                
                            </div> 
                            <div class="mb-4">
                                <label for="" class="mb-2">Quy mô</label>
                                <select name="company_size" id="company_size" class="form-control">
                                    <option value="">Chọn quy mô</option>
                                    <option {{ (Auth::user()->company_size == '1-10') ? 'selected' : '' }} value="1-10">1-10 nhân viên</option>
                                    <option {{ (Auth::user()->company_size == '11-50') ? 'selected' : '' }} value="11-50">11-50 nhân viên</option>
                                    <option {{ (Auth::user()->company_size == '51-100') ? 'selected' : '' }} value="51-100">51-100 nhân viên</option>
                                    <option {{ (Auth::user()->company_size == '101-500') ? 'selected' : '' }} value="101-500">101-500 nhân viên</option>
                                    <option {{ (Auth::user()->company_size == '501-1000') ? 'selected' : '' }} value="501-1000">501-1000 nhân viên</option>
                                    <option {{ (Auth::user()->company_size == '1000+') ? 'selected' : '' }} value="1000+">> 1000 nhân viên</option>
                                </select>
                                <p></p>
                            </div>
                                              
                        </div>
                        @if (Auth::user()->role == "employer")
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        @endif
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
<script>
     $('#companyForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'{{ route("account.updateCompany") }}',
            type:'put',
            data:$('#companyForm').serializeArray(),
            dataType:'json',
            success:function(res){
                if(res.status===false)
                {
                    var errors = res.errors;
                    if(errors.company_name)
                    {
                        $('#company_name').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_name)
                                                
                    }
                    else
                    {
                        $('#company_name').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.company_location)
                    {
                        $('#company_location').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_location)
                                                
                    }
                    else
                    {
                        $('#company_location').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.company_website)
                    {
                        $('#company_website').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_website)
                                                
                    }
                    else
                    {
                        $('#company_website').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    }
                    if(errors.company_address)
                    {
                        $('#company_address').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_address)
                                                
                    }
                    else
                    {
                        $('#company_address').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.company_description)
                    {
                        $('#company_description').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_description)
                                                
                    }
                    else
                    {
                        $('#company_description').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.company_size)
                    {
                        $('#company_size').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_size)
                                                
                    }
                    else
                    {
                        $('#company_size').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }

                }
                else
                {
                    $('#company_name').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#company_location').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('') 
                    $('#company_website').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#confirm_description').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#confirm_size').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    window.location.href = "{{ route('account.company') }}";                                               
                }
                
            }

        })
     })
</script>
@endsection
