@extends('front.layouts.app')
@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Tìm kiếm việc làm</h2>  
            </div>
            <div class="col-6 col-md-2">
                {{-- <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="">Mới nhất</option>
                        <option value="">Cũ nhất</option>
                    </select>
                </div> --}}
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                    <form action="" id="searchForm" name="searchForm">
                        <div class="mb-4">
                            <h2>Keywords</h2>
                            <input type="text" value="{{ Request::get('keyword') }}" placeholder="Keywords" name="keyword" id="keyword" class="form-control">
                        </div>
    
                        <div class="mb-4">
                            <h2>Địa điểm:</h2>
                            <select name="location" id="location" class="form-control">
                            <option value="">Tỉnh/Thành phố</option>
                            @if ($locations->isNotEmpty())
                                @foreach ($locations as $location )
                                    <option value="{{$location->id }}" {{ (Request::get('location')==$location->id)? 'selected':"" }}>{{ $location->name }}</option>
                                @endforeach
                            @endif
                            
                        </select>
                        </div>
    
                        <div class="mb-4">
                            <h2>Ngành nghề:</h2>
                            <select name="category" id="category" class="form-control">
                                <option value="">Chọn ngành nghề</option>
                                @if ($categories->isNotEmpty())
                                @foreach ($categories as $category )
                                    <option  value="{{$category->id }}" {{ (Request::get('category')==$category->id)? 'selected':"" }}>{{ $category->name }}</option>
                                @endforeach
                                @endif
                                {{-- <option value="">Engineering</option>
                                <option value="">Accountant</option>
                                <option value="">Information Technology</option>
                                <option value="">Fashion designing</option> --}}
                            </select>
                        </div>                   
    
                        <div class="mb-4">
                            <h2>Loại công việc</h2>
                            @if ($jobTypes->isNotEmpty())
                            @foreach ($jobTypes as $jobType)
                                <div class="form-check mb-2"> 
                                <input class="form-check-input " name="job_type" {{ (in_array($jobType->id,$jobTypeArray)) }} type="checkbox" value="{{ $jobType->id }}" id="job-type-{{ $jobType->id }}">    
                                <label class="form-check-label " for="">{{ $jobType->name }}</label>
                            </div>
                            @endforeach
                            @endif
                            
                        </div>
    
                        <div class="mb-4">
                            <h2>Kinh nghiệm</h2>
                            <select name="experience" id="experience" class="form-control">
                                <option value="">Chọn kinh nghiệm</option>
                                <option {{ (Request::get('experience') == '0_1') ? 'selected' : '' }} value="0_1">< 1 năm</option>
                                <option {{ (Request::get('experience') == '1_3') ? 'selected' : '' }} value="1_3">1-3 năm</option>
                                <option {{ (Request::get('experience') == '3_5') ? 'selected' : '' }} value="3_5">3-5 năm</option>
                                <option {{ (Request::get('experience') == '5_10') ? 'selected' : '' }} value="5_10">5-10 năm</option>
                                <option {{ (Request::get('experience') == '10_plus') ? 'selected' : '' }} value="10_plus">> 10 năm</option>
                            </select>
                        </div> 
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            
                              
                    </form>            
                </div>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                    <div class="row">
                        @if ($jobs->isNotEmpty())
                            @foreach ($jobs as $job)
                                <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0"><a href="{{ route('jobDetail',$job->id) }}">{{ $job->title }}</a></h3>
                                    <p>{{ Str::words($job->description,$word = 10,'...') }}</p>
                                    <div class="bg-light p-4 border">
                                        <p class="mb-0">
                                            
                                            <span class="ps-1">{{ $job->company_name }}</span>
                                        </p>
                                         <p class="mb-0">
                                            <span></span>
                                            <span class="ps-1">{{ $job->keywords }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{ $job->location->name }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{ $job->jobType->name }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{ $job->category->name }}</span>
                                        </p>
                                        <p class="mb-0">
                                           
                                            <span class="ps-1">Kinh nghiệm:{{ $job->experience }} năm</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $job->salary }}</span>
                                        </p>
                                        <p class="mb-0">
                                           
                                            <span class="ps-1">Ngày đăng:{{ $job->created_at->format('d/m/Y') }}</span>
                                        </p>
                                        
                                        <p>
                                            @if($job->deadline)
                                                @php
                                                    $deadline = \Carbon\Carbon::parse($job->deadline)->startOfDay();
                                                    $today = \Carbon\Carbon::now()->startOfDay();
                                                @endphp

                                                @if($deadline->isPast() && !$deadline->isToday())
                                                    <span class="text-danger small">
                                                        <i class="fa fa-times-circle"></i> Đã hết hạn
                                                    </span>
                                                @elseif($deadline->isToday())
                                                    <span class="text-warning small">
                                                        <i class="fa fa-exclamation-triangle"></i> Hạn chót hôm nay
                                                    </span>
                                                @else
                                                    <span class="text-success">
                                                         Còn <strong>{{ $today->diffInDays($deadline) }}</strong> ngày
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-muted small"><i class="fa fa-infinity"></i> Vô thời hạn</span>
                                            @endif
                                        </p>
                                    </div>

                                    
                                </div>
                            </div>
                            </div>
                            @endforeach
                            <div class="col-md-12">
                                {{ $jobs->links() }}
                            </div> 
                        @else
                            <div class="col-md-12">
                                <p>Ko tìm thấy công việc</p>
                            </div>    
                        @endif
                        
                        
                        {{-- <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">Web Developer</h3>
                                    <p>We are in need of a Web Developer for our company.</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">Noida</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">Remote</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">2-3 Lacs PA</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">Web Developer</h3>
                                    <p>We are in need of a Web Developer for our company.</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">Noida</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">Remote</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">2-3 Lacs PA</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">Web Developer</h3>
                                    <p>We are in need of a Web Developer for our company.</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">Noida</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">Remote</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">2-3 Lacs PA</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">Web Developer</h3>
                                    <p>We are in need of a Web Developer for our company.</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">Noida</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">Remote</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">2-3 Lacs PA</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">Web Developer</h3>
                                    <p>We are in need of a Web Developer for our company.</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">Noida</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">Remote</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">2-3 Lacs PA</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                                                 
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection
@section('customJs')
 <script>
    $('#searchForm').submit(function(e){
        e.preventDefault();
        var url = '{{ route('jobs') }}?'
        var keyword = $("#keyword").val()
        var category = $("#category").val()
        var location = $("#location").val()
        var experience = $("#experience").val()
        var checkedJobTypes=$("input:checkbox[name='job_type']:checked").map(function(){
            return $(this).val()
        }).get();
        if(keyword!=""){
            url += '&keyword='+ keyword
        }
        if(category!=""){
            url += '&category='+ category
        }
         if(location!=""){
            url += '&location='+ location
        }
        if(experience!=""){
            url += '&experience='+ experience
        }
        if(checkedJobTypes.length>0){
            url += '&jobType='+ checkedJobTypes
        }
        window.location.href = url;
     })
 </script>
@endsection