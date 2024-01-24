<div class="sidebar">
    <!-- logo -->
    <div class="logo">
        <a href="{{route('adminDashboard')}}">
            <img src="{{show_image(Auth::user()->id,'logo')}}" class="img-fluid" alt="">
        </a>
    </div><!-- /logo -->

    <!-- sidebar menu -->
    <div class="sidebar-menu">
        <nav>
            <ul id="metismenu">


{!! mainMenuRenderer('blogDashboard',__('Blog Dashboard'),$menu ?? '','blog-dashboard','dashboard.svg') !!}
{!! mainMenuRenderer('allBlogPage',__('Blogs'),$menu ?? '','blog-create','user.svg') !!}

{!! subMenuRenderer(__('Blog Category'),$menu ?? '', 'category','user.svg',[
    ['route' => 'CategoryPage', 'title' => __('Main Category'),'tab' => $sub_menu ?? '', 'tab_compare' => 'main_category', 'route_param' => NULL ],
    ['route' => 'SubCategoryPage', 'title' => __('Sub Category'),'tab' => $sub_menu ?? '', 'tab_compare' => 'sub_category', 'route_param' => NULL ],
]) !!}
{!! mainMenuRenderer('BlogComment',__('Comments'),$menu ?? '','comment','user.svg') !!}

{{-- {!! mainMenuRenderer('BlogCustomPages',__('Custom Page'),$menu ?? '','custom-pages','user.svg') !!} --}}
{!! mainMenuRenderer('BlogSettings',__('Blog Settings'),$menu ?? '','blog-settings','user.svg') !!}


{!! mainMenuRenderer('newsDashboard',__('News Dashboard'),$menu ?? '','dashboard','dashboard.svg') !!}
{!! mainMenuRenderer('adminDashboard',__('Admin Dashboard'),$menu ?? '','dashboard','dashboard.svg') !!}

            </ul>
        </nav>
    </div><!-- /sidebar menu -->

</div>