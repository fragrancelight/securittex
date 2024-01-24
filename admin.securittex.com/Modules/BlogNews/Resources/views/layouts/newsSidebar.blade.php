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


{!! mainMenuRenderer('newsDashboard',__('News Dashboard'),$menu ?? '','news-dashboard','dashboard.svg') !!}
{!! mainMenuRenderer('allNewsPage',__('News'),$menu ?? '','news-create','user.svg') !!}

{{-- {!! subMenuRenderer(__('News Category'),$menu ?? '', 'news-category','user.svg',[
    ['route' => 'newsCategoryPage', 'title' => __('Main Category'),'tab' => $sub_menu ?? '', 'tab_compare' => 'news-main_category', 'route_param' => NULL ],
    ['route' => 'newsSubCategoryPage', 'title' => __('Sub Category'),'tab' => $sub_menu ?? '', 'tab_compare' => 'news-sub_category', 'route_param' => NULL ],
]) !!} --}}
{!! mainMenuRenderer('newsCategoryPage',__('News Category'),$menu ?? '','news-category','user.svg') !!}
{!! mainMenuRenderer('NewsComment',__('Comments'),$menu ?? '','comment','user.svg') !!}

{{-- {!! mainMenuRenderer('NewsCustomPages',__('Custom Page'),$menu ?? '','custom-pages','user.svg') !!} --}}
{!! mainMenuRenderer('NewsSettings',__('News Settings'),$menu ?? '','news-settings','user.svg') !!}

{!! mainMenuRenderer('blogDashboard',__('Blog Dashboard'),$menu ?? '','dashboard','dashboard.svg') !!}
{!! mainMenuRenderer('adminDashboard',__('Admin Dashboard'),$menu ?? '','dashboard','dashboard.svg') !!}

            </ul>
        </nav>
    </div><!-- /sidebar menu -->

</div>