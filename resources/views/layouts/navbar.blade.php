<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Pages</a></li>
                @if(isset($breadcrumb) && is_array($breadcrumb))
                    @foreach ($breadcrumb as $item)
                        @if (isset($item['url']))
                            <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                        @else
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $item['label'] }}</li>
                        @endif
                    @endforeach
                @elseif(isset($pageTitle))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $pageTitle }}</li>
                @else
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Blank Page</li>
                @endif
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">
                @if(isset($pageTitle))
                    {{ $pageTitle }}
                @else
                @endif
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Sign In</span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>