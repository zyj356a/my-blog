<ul class="navbar-nav mr-auto" >
    <li class="nav-item"><a class="nav-link" href="/">首页</a></li>
    @auth
        <li @if(Request::is('admin/post*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/post">文章</a>
        </li>
        <li @if(Request::is('admin/tag*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/tag">标签</a>
        </li>
        <li @if(Request::is('admin/upload*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/upload">上传</a>
        </li>
    @endauth
</ul>
<ul class="navbar-nav ml-auto">
    @guest
        <li class="nav-item"><a class="nav-link" href="/login">登陆</a></li>
    @else
        <li class="nav-item dropdown">
            <a href="#" class="navlink dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu" role="menu">
                <a href="/logout" class="dropdown-item">退出</a>
            </div>
        </li>
    @endguest
</ul>