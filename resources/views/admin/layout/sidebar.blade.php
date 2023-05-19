<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin_home') }}">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin_home') }}"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::is('admin/home')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_home') }}"><i class="fa fa-hand-o-right"></i> <span>Dashboard</span></a></li>

            <li class="nav-item dropdown {{ Request::is('admin/room/show')||Request::is('admin/room/send-email') ? 'active' : '' }}">
                <a href="{" class="nav-link has-dropdown"><i class="fa fa-users"></i><span>Rooms Section</span></a>
                <ul class="dropdown-menu">

                    <li class="{{ Request::is('admin/room/view') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_room_view') }}"><i class="fa fa-angle-right"></i>Room</a></li>
                    <li class="{{ Request::is('admin/amenities/view') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_amenities_view') }}"><i class="fa fa-angle-right"></i>Amenities</a></li>

                    
                </ul>
            </li>
                                                                        //Pages
            <li class="nav-item dropdown active">
                <a  class="nav-item dropdown {{ Request::is('admin/page/about')||Request::is('admin/page/terms')||Request::is('admin/page/privacy')||Request::is('admin/page/contact')||Request::is('admin/page/photo-gallery')||Request::is('admin/page/video-gallery')||Request::is('admin/page/faq')||Request::is('admin/page/blog')||Request::is('admin/page/room')||Request::is('admin/page/cart')||Request::is('admin/page/checkout')||Request::is('admin/page/payment')||Request::is('admin/page/signup')||Request::is('admin/page/signin')||Request::is('admin/page/forget-password')||Request::is('admin/page/reset-password') ? 'active' : '' }}"><i class="fa fa-hand-o-right"></i><span>Pages</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/page/about')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_about') }}"><i class="fa fa-angle-right"></i>About</a></li>
                    <li class="{{ Request::is('admin/page/terms')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_terms') }}"><i class="fa fa-angle-right"></i>Terms and Conditions</a></li>
                    <li class="{{ Request::is('admin/page/privacy')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_privacy') }}"><i class="fa fa-angle-right"></i>Privacy Policy</a></li>
                    <li class="{{ Request::is('admin/page/contact')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_contact') }}"><i class="fa fa-angle-right"></i>Contact Us</a></li>
                    <li class="{{ Request::is('admin/page/photo')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_photo') }}"><i class="fa fa-angle-right"></i>Photo Page</a></li>
                    <li class="{{ Request::is('admin/page/video')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_video') }}"><i class="fa fa-angle-right"></i>Video Page</a></li>
                    <li class="{{ Request::is('admin/page/faq')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_faq') }}"><i class="fa fa-angle-right"></i>FAQ Page</a></li>
                    <li class="{{ Request::is('admin/page/blog')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_blog') }}"><i class="fa fa-angle-right"></i>Blog</a></li>
                    <li class="{{ Request::is('admin/page/cart')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_cart') }}"><i class="fa fa-angle-right"></i>Cart</a></li>
                    <li class="{{ Request::is('admin/page/checkout')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_checkout') }}"><i class="fa fa-angle-right">Checkout</i></a></li>
                    <li class="{{ Request::is('admin/page/payment')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_payment') }}"><i class="fa fa-angle-right">Payment</i></a></li>
                    <li class="{{ Request::is('admin/page/signup')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_signup') }}"><i class="fa fa-angle-right">Sign Up</i></a></li>
                    <li class="{{ Request::is('admin/page/signin')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_signin') }}"><i class="fa fa-angle-right">Sign In</i></a></li>
                    <li class="{{ Request::is('admin/page/forget_password')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_forget_password') }}"><i class="fa fa-angle-right">Forget Password Page</i></a></li>
                    <li class="{{ Request::is('admin/page/reset_password')? 'active' : '' }} "><a class="nav-link" href="{{ route('admin_page_reset_password') }}"><i class="fa fa-angle-right">Reset Password Page</i></a></li>
                    
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::is('admin/room/show')||Request::is('admin/subscriber/send-email') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-users"></i><span>Subscribers</span></a>
                <ul class="dropdown-menu">

                    <li class="{{ Request::is('admin/subscriber/show') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_subscriber_show') }}"><i class="fa fa-angle-right"></i> All Subscribers</a></li>

                    <li class="{{ Request::is('admin/subscriber/send-email') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_subscriber_send_email') }}"><i class="fa fa-angle-right"></i> Send Email</a></li>
                </ul>
            </li>

            <li class="{{ Request::is('admin/slide/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_slide_view') }}"><i class="fa fa-hand-o-right"></i> <span>Slide </span></a></li>
            
            <li class="{{ Request::is('admin/feature/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_feature_view') }}"><i class="fa fa-hand-o-right"></i> <span>Feature</span></a></li>
            <li class="{{ Request::is('admin/testimonial/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_testimonial_view') }}"><i class="fa fa-hand-o-right"></i> <span>Testimonial</span></a></li>
            <li class="{{ Request::is('admin/post/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_post_view') }}"><i class="fa fa-hand-o-right"></i> <span>Post</span></a></li>
            <li class="{{ Request::is('admin/photo/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_photo_view') }}"><i class="fa fa-hand-o-right"></i> <span>Photo Gallery</span></a></li>
            <li class="{{ Request::is('admin/video/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_video_view') }}"><i class="fa fa-hand-o-right"></i> <span>Video Gallery</span></a></li>
            <li class="{{ Request::is('admin/faq/*')? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_faq_view') }}"><i class="fa fa-hand-o-right"></i> <span>FAQ</span></a></li>
             
            

           
        </ul>
    </aside>
</div>