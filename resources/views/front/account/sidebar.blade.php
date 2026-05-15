<div class="card border-0 shadow mb-4 p-3">
                    <div class="s-body text-center mt-3">

                        @if(Auth::user()->role == "candidate")
                            {{-- Display for Candidate --}}
                            @if(Auth::user()->image)
                                <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            @else
                                <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            @endif
                            
                            <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
                            {{-- <p class="text-muted mb-1 fs-6">{{ Auth::user()->de }}</p> --}}

                        @elseif(Auth::user()->role == "employer")
                                {{-- Display for Employer --}}
                        @if(Auth::user()->company_logo)
                            <img src="{{ asset('company_logos/' . Auth::user()->company_logo) }}" alt="logo" class="rounded-circle img-fluid" style="width: 150px;">
                        @else
                            <img src="{{ asset('assets/images/avatar7.png') }}" alt="logo" class="rounded-circle img-fluid" style="width: 150px;">
                        @endif
                        
                        <h5 class="mt-3 pb-0">{{ Auth::user()->company_name }}</h5>
                        <p class="text-muted mb-1 fs-6">{{ Auth::user()->companyLocation?->name }}</p>
                        @endif

                        {{-- The button is common to both roles --}}
                        <div class="d-flex justify-content-center mb-2">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">
                                Change {{ Auth::user()->role == 'employer' ? 'Logo' : 'Profile Picture' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex justify-content-between p-3">
                                <a href="account.html">Thay đổi mật khẩu</a>
                            </li>
                            @if (Auth::user()->role=="employer")
                                {{-- <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="{{ route('account.createJob') }}">Đăng công việc</a>
                                </li> --}}
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <a href="{{ route('account.myJobs') }}">Các công việc của tôi</a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <a href="{{ route('account.myApplicants') }}">Danh sách ứng viên</a>
                                </li>
                            @endif
                            @if (Auth::user()->role=="candidate")
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="{{ route('account.myJobApplications') }}">Các công việc đã ứng tuyển</a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <a href="{{ route('account.mySaveJobs') }}">Lưu công việc</a>
                                </li> 
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="{{ route('account.logout') }}">Đăng xuất</a>
                            </li>                                                        
                        </ul>
                    </div>
                </div>