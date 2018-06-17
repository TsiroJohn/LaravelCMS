<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.index') }}"><i class="fa fa-user fa-fw"></i>Users</a>
                      
                    </li>

                    <li>
                        <a href="{{ route('admin.posts.index') }}"><i class="fa fa-pencil fa-fw"></i>Posts</a>
                       
                        <!-- /.nav-second-level -->
                    </li>


                    <li>
                        <a href="{{ route('admin.categories.index') }}"><i class="fa fa-archive fa-fw"></i>Categories</a>
                        
                        <!-- /.nav-second-level -->
                    </li>

                    <li>
                        <a href="{{ route('admin.media.index') }}"><i class="fa fa-image fa-fw"></i>Media</a>
                       
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="{{ route('admin.comments.index') }}"><i class="fa fa-comments fa-fw"></i>Comments</a>
                       
                        <!-- /.nav-second-level -->
                    </li>
                </ul>


            </div>
            <!-- /.sidebar-collapse -->
        </div>