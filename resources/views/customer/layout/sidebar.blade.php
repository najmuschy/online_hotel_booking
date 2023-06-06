<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('customer_home') }}">Customer Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('customer_home') }}"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::is('customer/home')? 'active' : '' }}"><a class="nav-link" href="{{ route('customer_home') }}"><i class="fa fa-hand-o-right"></i> <span>Customer Dashboard</span></a></li>
            
            <li class="{{ Request::is('customer/order/*')? 'active' : '' }} "><a class="nav-link" href="{{ route('customer_order_view') }}"><i class="fa fa-angle-right"></i>Orders</a></li> 

            <!-- {{-- <li class="nav-item dropdown {{ Request::is('customer/room/show')||Request::is('customer/room/send-email') ? 'active' : '' }}">
                <a href="{" class="nav-link has-dropdown"><i class="fa fa-users"></i><span>Rooms Section</span></a>
                <ul class="dropdown-menu">

                    <li class="{{ Request::is('customer/room/view') ? 'active' : '' }}"><a class="nav-link" href="{{ route('customer_room_view') }}"><i class="fa fa-angle-right"></i>Room</a></li>
                    <li class="{{ Request::is('customer/amenities/view') ? 'active' : '' }}"><a class="nav-link" href="{{ route('customer_amenities_view') }}"><i class="fa fa-angle-right"></i>Amenities</a></li> 

                    
                </ul>
            </li>  --}} -->
            
                    

           
        </ul>
    </aside>
</div>