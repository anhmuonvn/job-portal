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
            <div class="col-md-8">
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
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="#"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Mô tả công việc</h4>
                            {!! nl2br(e($job->description)) !!}
                        </div>
                        
                            
                            @if (!empty($job->responsibility))
                            <div class="single_wrap"></div>
                                <h4>Trách nhiệm công việc</h4>
                                 {!! nl2br(e($job->responsibility)) !!}
                                  </div>
                            @endif
                           
                       
                        
                             @if (!empty($job->qualifications))
                             <div class="single_wrap">
                            
                                <h4>Trình độ chuyên môn</h4>
                                 {!! nl2br(e($job->qualifications)) !!}
                                </div>
                            @endif
                            
                        
                        
                            
                            @if (!empty($job->benefits))
                            <div class="single_wrap">
                            <h4>Quyền lợi</h4>
                                 {!! nl2br(e($job->benefits)) !!}
                            </div>     
                            @endif
                            {{-- {!! nl2br(e($job->benefits)) !!} --}}
                        
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            <a href="#" class="btn btn-secondary">Lưu công việc</a>
                            
                            @if(Auth::check())
                                
                                <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary">Ứng tuyển</a>
                            @else
                                <a href="javascript:void();" class="btn btn-primary disabled">Đăng nhập để ứng tuyển</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Tóm tắt công việc</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Ngày đăng: <span>{{ $job->created_at->format('d/m/Y') }}</span></li>
                                <li>Vị trí trống: <span>{{ $job->vacancy }}</span></li>
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
                                <li>Tên công ty: <span>{{ $job->company_name }}</span></li>
                                @if (!empty($job->company_location))
                                    <li>Địa điểm công ty: <span><a href={{ $job->company_location }}></a></span></li>
                                @endif
                                {{-- <li>Địa điểm công ty: <span>{{ $job->company_location }}</span></li> --}}
                                <li>Địa chỉ chi tiết: <span>{{ $job->address }}</span></li>
                                @if (!empty($job->company_website))
                                    <li>Website: <span><a href={{ $job->company_website }}></a></span></li>
                                @endif
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4">
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3 >
                                Việc làm tương tự
                            </h3>
                        </div>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        @if($relateJobs->isNotEmpty())
                            @foreach($relateJobs as $relateJob)
                                <a href="{{ route('jobDetail',$relateJob->id) }}"  class="list-group-item list-group-item-action border-0 px-0 py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold text-success">{{ $relateJob->title }}</h6>
                            </div>
                            <p class="mb-1 text-muted small">{{ $relateJob->company_name }}</p>
                            <div class="d-flex align-items-center">
                                <small class="text-secondary me-3">
                                    <i class="bi bi-geo-alt"></i> {{ $relateJob->company_location }}
                                </small>
                                
                            </div>
                        </a>
                            @endforeach
                        @endif
                        

                        {{-- <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold text-success">Công nhân Đứng máy Đúc</h6>
                            </div>
                            <p class="mb-1 text-muted small">Tập đoàn Công nghiệp XYZ</p>
                            <div class="d-flex align-items-center">
                                <small class="text-secondary me-3">
                                    <i class="bi bi-geo-alt"></i> Ninh Bình
                                </small>
                                
                            </div>
                        </a> --}}
                    </div>

                    {{-- <div class="mt-2 text-center">
                        <a href="#" class="text-decoration-none small fw-bold text-primary">
                            Xem tất cả việc làm cùng ngành <i class="bi bi-arrow-right"></i>
                        </a>
                    </div> --}}
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
                    url:'',
                    type:'post',
                    data:{id:id},
                    dataType:'json',
                    success:function(res){
                        if(res.status===true){
                            window.location.reload;
                        }
                    }
                })
            }
        }
    </script>

@endsection