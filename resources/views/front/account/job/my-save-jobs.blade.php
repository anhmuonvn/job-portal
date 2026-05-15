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
                <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <h3 class="fs-4 mb-1">Các công việc đã lưu</h3>
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
                                        @if($saveJobs->isNotEmpty())
                                            @foreach($saveJobs as $saveJob )
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500"><a href="{{ route('jobDetail', $saveJob->job_id) }}">{{ $saveJob->job->title }}</a></div>
                                                        <div class="info1">{{ $saveJob->job->jobType->name }} .{{ $saveJob->job->location->name }}</div>
                                                    </td>
                                                    <td>{{ $saveJob->created_at->format('d M, Y') }}</td>
                                                    
                                                    <td>{{ $saveJob->user->cv }}</td>
                                                    <td>
                                                        @if ($saveJob->job->status==1)
                                                             <div class="job-status text-capitalize">Hoạt động</div>
                                                        @else
                                                              <div class="job-status text-capitalize">Tạm dừng</div>     
                                                        @endif
                                                       
                                                    </td>
                                                    {{-- <td>
                                                        <div class="action-dots " >
                                                            <button  class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="{{ route('jobDetail',$saveJob->job_id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> Xem</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="removeJob({{ $saveJob->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a></li>
                                                            </ul>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="6">Các công việc  lưu ko  thấy được</td>    
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
{{-- @section('customJs')
  <script>
     function removeJob(id){
         if(confirm('Bạn có xóa việc lưu này ko'))
         {
            $.ajax({
                url:"{{ route('account.removeSaveJob') }}",
                type:'post',
                data:{id:id},
                dataType:'json',
                success:function(response){
                    window.location.href = '{{ route('account.saveJobs') }}';
                }
            })
         }
     }
  </script>
@endsection --}}