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


{!! mainMenuRenderer('p2pDashboard',__('Dashboard'),$menu ?? '','dashboarded','dashboard.svg') !!}
{!! mainMenuRenderer('p2pCoinList',__('Coins'),$menu ?? '','coins','coin.svg') !!}
{!! mainMenuRenderer('p2pCurrencyList',__('Currency'),$menu ?? '','currency','fiat.svg') !!}
{!! mainMenuRenderer('adsListPage',__('Ads List'),$menu ?? '','ads','logs.svg') !!}
{!! mainMenuRenderer('paymentMethodList',__('Payment Method'),$menu ?? '','payment_method','fiat1.svg') !!}
{!! mainMenuRenderer('p2pPaymentTime',__('Payment Time'),$menu ?? '','payment_time','addon.svg') !!}

{!! mainMenuRenderer('getDisputedList',__('Dispute List'),$menu ?? '','p2p_dispute_list','addon.svg') !!}

{!! mainMenuRenderer('p2pSettingPage',__('Settings'),$menu ?? '','setting','settings.svg') !!}

{!! subMenuRenderer(__('Landing Settings'),$menu ?? '', 'landing','landing-settings.svg',[
   ['route' => 'landingSettingsP2p', 'title' => __('Header Setting'),'tab' => $sub_menu ?? '', 'tab_compare' => 'header_setting', 'route_param' => NULL ],
   ['route' => 'landingHowToP2p', 'title' => __('How To Work'),'tab' => $sub_menu ?? '', 'tab_compare' => 'how_to', 'route_param' => NULL ],
   ['route' => 'landingAdvantageP2p', 'title' => __('Advantage Of P2P'),'tab' => $sub_menu ?? '', 'tab_compare' => 'advantage', 'route_param' => NULL ],
]) !!}

{!! subMenuRenderer(__('Trade'),$menu ?? '', 'trade','Transaction-1.svg',tradeStatusRouteList($sub_menu??'')) !!}
{!! subMenuRenderer(__('Gift Card Trade'),$menu ?? '', 'gift_card','landing-settings.svg',[
   ['route' => 'getGiftCardAdsHistory', 'title' => __('Advertisements'),'tab' => $sub_menu ?? '', 'tab_compare' => 'advertisements', 'route_param' => NULL ],
   ['route' => 'getGiftCardOrderHistory', 'title' => __('Orders'),'tab' => $sub_menu ?? '', 'tab_compare' => 'orders', 'route_param' => NULL ],
   ['route' => 'disputeGiftCardList', 'title' => __('Dispute List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'gift_card_dispute_list', 'route_param' => NULL ],
   ['route' => 'getGiftHeader', 'title' => __('Header'),'tab' => $sub_menu ?? '', 'tab_compare' => 'gift_card_header', 'route_param' => NULL ],
]) !!}
{!! mainMenuRenderer('adminLogs',__('Logs'),$menu ?? '','log','menu.svg') !!}
{!! mainMenuRenderer('adminDashboard',__('Admin Dashboard'),$menu ?? '','dashboard','trade-report.svg') !!}

            </ul>
        </nav>
    </div><!-- /sidebar menu -->

</div>
