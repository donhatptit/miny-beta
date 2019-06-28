<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="header">Quản lý chung</li>
<li><a href="{{ backpack_url('dashboard') }}">
        <i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span>
    </a></li>
<li class="header">Quản lý tài nguyên</li>
<li class="treeview">
    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Posts</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('post') }}"><i class="fa fa-newspaper-o"></i> <span>Posts</span></a></li>
        <li><a href="{{ backpack_url('post-answer') }}"><i class="fa fa-newspaper-o"></i> <span>Post Answer</span></a></li>
        <li><a href="{{ backpack_url('kind') }}"><i class="fa fa-newspaper-o"></i> <span>Thể loại môn văn</span></a></li>
        {{--<li><a href="{{ backpack_url('category') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>--}}
        <li><a href="{{ backpack_url('tag') }}"><i class="fa fa-tag"></i> <span>Tags</span></a></li>
        <li><a href="{{ route('admin.category') }}"><i class="fa fa-list"></i> <span>Quản lý danh mục</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Question</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('question') }}'><i class='fa fa-newspaper-o'></i> <span>Danh sách câu hỏi</span></a></li>
        <li><a href='{{ backpack_url('question-category') }}'><i class='fa fa-list'></i> <span>Danh mục câu hỏi</span></a></li>
        <li><a href='{{ backpack_url('tag') }}'><i class='fa fa-tag'></i> <span>Tags</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-snowflake-o"></i> <span>Equation</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('equation') }}'><i class='fa fa-list'></i> <span>Danh sách phương trình</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-graduation-cap"></i> <span>Tuyển sinh</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('university') }}'>
                <i class='fa fa-university'></i> <span>Danh sách trường học</span>
            </a></li>
        <li><a href='{{ backpack_url('topic') }}'><i class='fa fa-newspaper-o'></i> <span>Danh sách topic</span></a></li>
        <li><a href='{{ backpack_url('ts-post') }}'><i class='fa fa-newspaper-o'></i> <span>Danh sách Post</span></a></li>
        <li><a href='{{ backpack_url('major') }}'><i class='fa  fa-cubes'></i> <span>Danh sách ngành đại học</span></a></li>
        <li><a href='{{ backpack_url('location') }}'>
                <i class='fa fa-map-marker'></i> <span>Danh sách đơn vị hành chính</span>
            </a></li>
        <li><a href='{{ backpack_url('image') }}'><i class='fa fa-photo '></i> <span>Image</span></a></li>
        <li><a href='{{ backpack_url('university-attribute') . '?type=0' }}'>
                <i class='fa fa-info-circle '></i> <span>Thông tin tuyển sinh các trường</span>
            </a></li>
        <li><a href='{{ backpack_url('university-attribute') . '?type=1' }}'>
                <i class='fa fa-briefcase '></i> <span>Thông tin về điểm chuẩn</span>
            </a></li>
        <li><a href='{{ backpack_url('score') }}'><i class='fa  fa-graduation-cap'></i> <span>Điểm đại học</span></a></li>
    </ul>
</li>
@role('Administrator')
<li class="header">App</li>
<li><a href="{{ backpack_url('report') }}"><i class="fa fa-commenting"></i> <span>Report</span></a></li>
<li class="header">Giao diện</li>
<li><a href="{{ url('admin/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>
<li class="header">Quản lý hệ thống</li>
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Quản lý người dùng</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}">
                <i class="fa fa-user"></i> <span>Quản lý user</span>
            </a>
        </li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}">
                <i class="fa fa-group"></i> <span>Quản lý role</span>
            </a></li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}">
                <i class="fa fa-key"></i> <span>Quản lý quyền</span>
            </a></li>
        <li><a href="{{ route('admin.user.token.list') }}">
                <i class="fa fa-user-secret"></i> <span>Token User</span>
            </a></li>
        <li><a href='{{ backpack_url('token-device') }}'><i class='fa fa-list'></i> <span>Token Device</span></a></li>
    </ul>
</li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
<li><a href="{{ backpack_url('backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a></li>
<li><a href="{{ backpack_url('log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
<li><a href="{{ backpack_url('setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
@endrole
<li class="header">Hướng dẫn</li>
<li><a href='{{ backpack_url('guideline') }}'><i class='fa fa-book'></i> <span>Guideline</span></a></li>
<li class="header">Demo Post</li>
<li><a href='{{ backpack_url('demoposts') }}'><i class='fa fa-book'></i> <span>DemoPosts</span></a></li>