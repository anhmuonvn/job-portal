@extends('front.layouts.app')
@section('main')
   <section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh sách ứng viên ứng tuyển</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
                
            </div>
             <div class="col-lg-9">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Danh sách ứng viên ứng tuyển của tôi</h3>
                            </div>
                            
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Ảnh ứng viên</th>
                                        <th scope="col">Tên ứng viên</th>
                                        <th scope="col">Chức danh</th>
                                        <th scope="col">Ngày ứng tuyển</th>
                                        <th scope="col">Công việc ứng tuyển</th>
                                        <th scope="col">Xem CV</th>

                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $application )
                                            <tr>
                                                <td>
                                                    <img src="{{  asset('profile_pic/'.$application->user->image)  }}" 
                                                            class="rounded-circle border" 
                                                            style="width: 50px; height: 50px; object-fit: cover;" 
                                                            alt="Avatar">
                                                </td>
                                                <td><a href="{{ route('account.showCandidate', $application->user->id) }}">{{ $application->user->name }}</a></td>
                                                <td>{{ $application->user->designation }}</td>
                                                <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('jobDetail',$application->job_id) }}">{{ $application->job->title }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset('uploads/cv/'.$application->user->cv) }}" target="_blank">
                                                        Xem CV
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                        {{ $applications->links() }}
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection