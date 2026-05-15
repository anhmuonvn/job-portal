@extends('front.layouts.app')
@section('main')
    <section class="section-5 bg-2">
    <div class="container py-5">
        
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.alert')
                <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <h3 class="fs-4 mb-1">Các công việc đã ứng tuyển</h3>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Tiêu đề</th>
                                            <th scope="col">Thời gian tạo</th>
                                            
                                            <th scope="col">CV</th>
                                            <th scope="col">Trạng thái</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($jobApplications->isNotEmpty())
                                            @foreach ($jobApplications as $jobApplication )
                                                <tr class="active">
                                                    <td>
                                                        <a href="{{ route('jobDetail',$jobApplication->job_id) }}"><div class="job-name fw-500">{{ $jobApplication->job->title }}</div></a>
                                                        <div class="info1">{{ $jobApplication->job->jobType->name }} .{{ $jobApplication->job->location->name }}</div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($jobApplication->applied_date)->format('d M, Y') }}</td>
                                                    
                                                    <td>{{ $jobApplication->user->cv }}</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">Hoạt động</div>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="6">Các đơn ứng tuyển ko tìm thấy</td>    
                                        @endif
                                        
                                        {{-- <tr class="pending">
                                            <td>
                                                <div class="job-name fw-500".html Developer</div>
                                                <div class="info1">Part-time . Delhi</div>
                                            </td>
                                            <td>13 Aug, 2023</td>
                                            <td>20 Applications</td>
                                            <td>
                                                <div class="job-status text-capitalize">pending</div>
                                            </td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="expired">
                                            <td>
                                                <div class="job-name fw-500">Full Stack Developer</div>
                                                <div class="info1">Fulltime . Noida</div>
                                            </td>
                                            <td>27 Sep, 2023</td>
                                            <td>278 Applications</td>
                                            <td>
                                                <div class="job-status text-capitalize">expired</div>
                                            </td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">Developer for IT company</div>
                                                <div class="info1">Fulltime . Goa</div>
                                            </td>
                                            <td>14 Feb, 2023</td>
                                            <td>70 Applications</td>
                                            <td>
                                                <div class="job-status text-capitalize">active</div>
                                            </td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> Xem</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div> 
        </div>
    </div>
</section>
@endsection
