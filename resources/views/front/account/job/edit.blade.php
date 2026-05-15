@extends('front.layouts.app')
@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Post a Job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4 ">
                    <div class="card-body card-form p-4">
                        <form action="" id="editJobForm" name="editJobForm">
                            <h3 class="fs-4 mb-1">Thông tin cập nhật công việc</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Tiêu đề<span class="req">*</span></label>
                                    <input type="text" value="{{ $job->title }}" placeholder="Nhập tiêu đề tin" id="title" name="title" class="form-control">
                                    <p></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Ngành nghề<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Chọn ngành nghề</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category )
                                                <option {{ ($job->category_id==$category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                        
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Loại công việc<span class="req">*</span></label>
                                    <select name="jobType" id="jobType" class="form-select">
                                        <option>Chọn loại công việc</option>
                                        @if ($jobTypes->isNotEmpty())
                                            @foreach ($jobTypes as $jobType )
                                                <option {{ ($job->job_type_id==$jobType->id) ? 'selected' : '' }} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                            @endforeach
                                        @endif
                                        
                                    </select>
                                    <p></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Số lượng tuyển<span class="req">*</span></label>
                                    <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                    <p></p>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Lương</label>
                                    <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                    
                                </div>
    
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Tỉnh/Thành Phố</label>
                                    
                                    <input type="text" placeholder="Tỉnh/Thành Phố" id="location_id" name="location_id" 
                                    value="{{ $job->user->companyLocation?->name ?? 'Chưa cập nhật địa điểm' }}" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Địa chỉ chi tiết công ty<span class="req">*</span></label>
                                <input type="text" class="form-control" name="address" id="address" value="{{ Auth::user()->company_address }}"  placeholder="Nhập địa chỉ chi tiết">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Mô tả công việc<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Nhập mô tả">{{ $job->description }}</textarea>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Quyền lợi<span class="req">*</span></label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">
                                    {{ $job->benefits }}
                                </textarea>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Nhiệm vụ<span class="req">*</span></label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">
                                    {{ $job->responsibility }}
                                </textarea>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Yêu cầu chuyên môn<span class="req">*</span></label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">
                                    {{ $job->qualifications }}
                                </textarea>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Kinh nghiệm<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control">
                                    <option  value="">Chọn kinh nghiệm</option>
                                        <option {{ ($job->experience == '0_1') ? 'selected' : '' }} value="0_1">< 1 năm</option>
                                        <option {{ ($job->experience == '1_3') ? 'selected' : '' }} value="1_3">1-3 năm</option>
                                        <option {{ ($job->experience == '3_5') ? 'selected' : '' }} value="3_5">3-5 năm</option>
                                        <option {{ ($job->experience == '5_10') ? 'selected' : '' }} value="5_10">5-10 năm</option>
                                        <option {{ ($job->experience == '10_plus') ? 'selected' : '' }} value="10_plus">> 10 năm</option>
                                </select>
                                <p></p>
                            </div> 
                            
    
                            <div class="mb-4">
                                <label for="" class="mb-2">Từ khóa</label>
                                <input type="text" value="{{ $job->keywords }}" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Hạn nộp hồ sơ:</label>
                                <input value="{{ $job->deadline ? $job->deadline->format('Y-m-d') : '' }}" type="date" placeholder="Hạn nộp hồ sơ" id="deadline" name="deadline" class="form-control">
                                <p></p>
                            </div>
                            
                            </div> 
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>         
                        </form>      
            </div>
            
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
     $('#editJobForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'{{ route("account.updateJob",$job->id) }}',
            type:'post',
            data:$('#editJobForm').serializeArray(),
            dataType:'json',
            success:function(response){
                if(response.status===false)
                {
                    var errors = response.errors;
                    if(errors.title)
                    {
                        $('#title').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.title)
                                                
                    }
                    else
                    {
                        $('#title').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.category)
                    {
                        $('#category').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.category)
                                                
                    }
                    else
                    {
                        $('#category').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.jobType)
                    {
                        $('#jobType').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.jobType)
                                                
                    }
                    else
                    {
                        $('#jobType').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    }
                    if(errors.vacancy)
                    {
                        $('#vacancy').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.vacancy)
                                                
                    }
                    else
                    {
                        $('#vacancy').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.description)
                    {
                        $('#description').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.description)
                                                
                    }
                    else
                    {
                        $('#description').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.responsibility)
                    {
                        $('#responsibility').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.responsibility)
                                                
                    }
                    else
                    {
                        $('#responsibility').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.benefits)
                    {
                        $('#benefits').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.benefits)
                                                
                    }
                    else
                    {
                        $('#benefits').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.qualifications)
                    {
                        $('#qualifications').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.qualifications)
                                                
                    }
                    else
                    {
                        $('#qualifications').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.deadline)
                    {
                        $('#deadline').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.deadline)
                                                
                    }
                    else
                    {
                        $('#deadline').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }
                    if(errors.experience)
                    {
                        $('#experience').addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.experience)
                                                
                    }
                    else
                    {
                        $('#experience').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                                                
                    }

                }
                else
                {
                    $('#title').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#category').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('') 
                    $('#jobType').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#vacancy').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#requirements').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#description').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')            
                    $('#benefits').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#qualifications').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#deadline').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    $('#experience').removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('')
                    window.location.href = "{{ route('account.myJobs') }}";                                               
                }
                
            }

        })
     })
</script>
@endsection