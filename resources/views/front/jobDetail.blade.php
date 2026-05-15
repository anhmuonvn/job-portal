@extends('front.layouts.app')
@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true">
                            </i> &nbsp;Quay lại trang danh sách công việc</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{ $job->location->name }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>{{ $job->jobType->name }} </p>
                                        </div>
                                        {{-- <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>{{ $job->category->name }} </p>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="jobs_right">
                                <div class="apply_now {{ ($count==1)?"saved-job":"" }}">
                                    <a class="heart_mark" href="javascript::void(0);" onclick="saveJob({{ $job->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <!-- 1. Mô tả công việc -->
                            <div class="single_wrap">
                                <h4>Mô tả công việc</h4>
                                {!! nl2br(e($job->description)) !!}
                            </div>

                            <!-- 2. Trách nhiệm công việc (ĐÃ SỬA) -->
                        <div class="single_wrap"> <!-- Bỏ dấu /> ở đây -->
                            <h4>Trách nhiệm công việc</h4>
                            {!! nl2br(e($job->responsibility)) !!}
                        </div>

                        <!-- 3. Trình độ chuyên môn -->
                        @if (!empty($job->qualifications))
                            <div class="single_wrap">
                                <h4>Trình độ chuyên môn</h4>
                                {!! nl2br(e($job->qualifications)) !!}
                            </div>
                        @endif

                        <!-- 4. Quyền lợi -->
                        @if (!empty($job->benefits))
                            <div class="single_wrap">
                                <h4>Quyền lợi</h4>
                                {!! nl2br(e($job->benefits)) !!}
                            </div>     
                        @endif
                        
                        <div class="border-bottom">

                        </div>
                        <div class="pt-3 text-end">
                            @if(Auth::check())
                               
                                 @if (Auth::user()->role=="candidate")
                                     <a href="#" onclick="saveJob({{ $job->id }}); return false;" class="btn btn-secondary">Lưu công việc</a>
                                     @if (\Carbon\Carbon::parse($job->deadline)->isPast())
                                         <button class="btn btn-secondary" disabled>Đã hết hạn</button>
                                     @else    
                                         <a href="#" onclick="applyJob({{ $job->id }}); return false;" class="btn btn-primary">Ứng tuyển</a>
                                     @endif
                                    
                                 
                                 @endif
                                 @if (Auth::user()->role=="employer")
                                     <a href="{{ route('account.editJob', $job->id) }}" class="btn btn-secondary">Chỉnh sửa công việc</a>
                                 @endif
                            @else
                                <a href="{{ route('account.login') }}" class="btn btn-secondary">Đăng nhập để lưu công việc</a>
                                <a href="{{ route('account.login') }}" class="btn btn-primary">Đăng nhập để ứng tuyển</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                
                    <div class="card shadow border-0">
                    @if (Auth::check())
                        @if (Auth::user()->role=="employer"&&Auth::user()->id==$job->user_id)    
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Thông tin  ứng viên nộp đơn</h3>
                        </div>
                        <div class="job_content pt-3">
                            <table class="table table-str">
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                
                                <th>Ngày nộp đơn</th>
                            </tr>
                            @if ($applications->isNotEmpty())
                                 
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->user->name }}</td>
                                        <td>{{ $application->user->email }}</td>
                                        
                                        <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">Danh sách ứng viên ko được tìm thấy</td>
                                    </tr>
                               @endif
                            
                        </table>
                        </div>
                    </div>
                    </div>
                    @endif
                    @endif
                    <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Tóm tắt công việc</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Ngày đăng: <span>{{ $job->created_at->format('d/m/Y') }}</span></li>
                                <li>Vị trí tuyển: <span>{{ $job->vacancy }}</span></li>
                                @if (!empty($job->salary))
                                    <li>Lương: <span>{{ $job->salary }}</span></li>
                                @endif
                                {{-- <li>Lương: <span>{{ $job->salary }}</span></li> --}}
                                <li>Location: <span>{{ $job->location->name }}</span></li>
                                <li>Job Nature: <span> {{ $job->jobType->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Thông tin công ty</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Tên công ty: 
                                    <span>
                                        <a href="{{ route('account.companyDetail',$job->user->id) }}">{{ $job->user->company_name }}</a>
                                    </span>
                                </li>
                                @if (!empty($job->company_location))
                                    <li>Địa điểm công ty: <span><a href={{ $job->company_location }}></a></span></li>
                                @endif
                                {{-- <li>Địa điểm công ty: <span>{{ $job->company_location }}</span></li> --}}
                                <li>Địa chỉ chi tiết: <span>{{ $job->address }}</span></li>
                                @if (!empty($job->company_website))
                                    <li>Website: <span><- href={{ $job->user->company_website }}></a></span></li>
                                @endif
                                
                            </ul>
                        </div>
                    </div>
                </div>
                    
                
                   
                
                
                <div class="card shadow-sm border-0 mt-4">
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4 ps-3">
                            <h3>Việc làm tương tự</h3>
                        </div>
                    </div>
    
                    <div class="list-group list-group-flush px-3">
                        @if($relateJobs->isNotEmpty())
                            @foreach($relateJobs as $relateJob)
                                <a href="{{ route('jobDetail', $relateJob->id) }}" class="list-group-item list-group-item-action border-0 px-0 py-3 border-bottom">
                                    <div class="d-flex align-items-center w-100">
                                        
                                        <div class="company-logo me-3">
                                            @if(!empty($relateJob->user) && !empty($relateJob->user->company_logo))
                                                <img src="{{ asset('company_logos/' . $relateJob->Auth::user()->company_logo) }}" alt="Logo" class="rounded border" style="width: 55px; height: 55px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/images/default-company.png') }}" alt="Logo" class="rounded border" style="width: 55px; height: 55px; object-fit: cover;">
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 fw-bold text-success" style="font-size: 15px;">
                                                    {{ $relateJob->title }}
                                                </h6>
                                            </div>
                                            
                                            <p class="mb-1 text-muted small">
                                                <i class="bi bi-building me-1">
                                                {{ $relateJob->user->company_name  }}
                                            </p>
                                            
                                            <div class="d-flex align-items-center">
                                                <small class="text-secondary">
                                                    <i class="bi bi-geo-alt me-1"></i> {{ $relateJob->location->name }}
                                                </small>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="py-3 text-muted ps-3">Không có việc làm tương tự</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
    <script type="text/javascript">
        function applyJob(id){
            if(confirm('Bạn có muốn ứng tuyển công việc này ko?'))
            {
                $.ajax({
                    url: "{{ route('applyJob') }}",
                    type:'post',
                    data:{id:id},
                    dataType:'json',
                    success:function(res){
                        if(res.status===true){
                            window.location.href = "{{ route('account.myJobApplications') }}";
                        }
                    }
                })
            }
        };
        function saveJob(id){
            if(confirm('Bạn có muốn lưu công việc này ko?'))
            {
                $.ajax({
                    url: "{{ route('saveJobs') }}",
                    type:'post',
                    data:{id:id},
                    dataType:'json',
                    success:function(res){
                        if(res.status===true){
                            window.location.href = "{{ route('account.mySaveJobs') }}";
                        }
                    }
                })
            }
        }
    </script>

@endsection