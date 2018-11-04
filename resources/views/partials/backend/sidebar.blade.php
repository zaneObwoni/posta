<!-- sidebar start-->
<aside>
    <div class="nav-collapse" id="sidebar">
        <!-- sidebar menu start-->
        <div class="leftside-navigation" style="overflow-y:scroll;">
            <ul class="sidebar-menu" id="nav-accordion">
                @if(Auth::User()->isAdmin())
                    <h4>General Admin</h4>
                    <li>
                        <a href="{!! route('admin.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Admin Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('admin.staff.index') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Staff</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.user.index') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>User Account</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.corporates') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Corporate Account</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.physical') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Physical Boxes</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.emails') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Admin Emails</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.notifications') !!}">
                            <i class="fa fa-bell-o"></i>
                            <span>Admin Notifications</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.drivers') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>All Drivers/Riders</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.deliveries') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>All Deliveries</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.pickings') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Pick-ups</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.main.pickings.create') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Registered Pickups</span>
                        </a>
                    </li>

                @endif

                @if(Auth::User()->isPMG())
                    <h4>Post Master General</h4>
                    <li>
                        <a href="{!! route('admin.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('admin.staff.index') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Staff</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.user.index') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>User Account</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.corporates') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Corporate Account</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.drivers') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>All Drivers/Riders</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.deliveries') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>All Deliveries</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.pickings') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Pick-ups</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.main.pickings.create') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Registered Pickups</span>
                        </a>
                    </li>
                @endif

                @if(Auth::User()->isPostMaster())
                    <li>
                        <a>
                            <h2>Post Master</h2>
                            <span style="font-size: 14px; padding-left: 10px;">
                                ({!!DB::table('post_codes')->select('zone')->where('number',$user->postcode_id)->first()->zone !!})
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('pm.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Post Master</span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('pm.staff') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Staff</span>
                        </a>
                    </li>

                @endif

                @if(Auth::User()->isFinance())
                    <li>
                        <h2>Finance</h2>
                    </li>
                    <li>
                        <a href="{!! route('finance.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Finance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('finance.accounts') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Accounts</span>
                        </a>
                    </li>

                @endif

                @if(Auth::User()->isAgentPay())
                    <li>
                        <h2>Agent Pay</h2>
                    </li>
                    <li>
                        <a href="{!! route('agentpay.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Agent Manager</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('agentpay.agents') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Agents</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('agentpay.earning') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Agent Earning List</span>
                        </a>
                    </li>

                @endif

                @if(Auth::User()->isUser())
                    @if(Auth::User()->code == 1111)
                        <li>
                            <a href="{!! route('user.dashboard') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Awaiting Verification</span>
                            </a>
                        </li>
                    @elseif(Auth::User()->active == 0)
                        <li>
                            <a href="{!! route('success') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Please Pay Now</span></a>
                        </li>

                        <li>
                            <a href="{!! route('user.dashboard') !!}">
                                <span>Paid! Click here.</span>
                            </a>
                        </li>
                    @else

                        <li>
                            <a href="{!! route('user.dashboard') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>My Dashboard</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="{!! route('user.profile') !!}">
                                <i class="fa fa-truck"></i>
                                <span>My Profile</span>
                            </a>                
                        </li>

                        <li class="sub-menu">
                            <a href="{!! route('emails.index') !!}">
                                <i class="fa fa-envelope"></i>
                                <span>My EMail </span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('notifications.index') !!}">
                                <i class="fa fa-bell-o"></i>
                                <span>My Notifications</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('estamps.index') !!}">
                                <i class="fa fa-cog"></i>
                                <span>Your E-Stamps</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span>Buy E-Stamps:-</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{!! route('estamps.create') !!}">Ordinary Mail</a></li>
                                <!-- <li><a href="/user/wishes/stamp">Best Wishes</a></li> -->
                                <li><a href="{!! route('registers.create') !!}">Registered Mail</a></li>
                                <li><a href="{!! route('ems.create') !!}">EMS Courier Services</a></li>
                             
                            </ul>
                        </li>

                        <li>
                            <a href="{!! route('bestwishes.index') !!}">
                                <i class="fa fa-cog"></i>
                                <span>My Seasons Greetings</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('deliveries.index') !!}">
                                <i class="fa fa-truck"></i>
                                <span>My Deliveries</span>
                            </a>
                        </li>


                        <li class="sub-menu">
                            <a href="{!! route('pickings.index') !!}">
                                <i class="fa fa-truck"></i>
                                <span>My Pick-Ups</span>
                            </a>

                        </li>

                        <li>
                            <a href="{!! route('user.changepassword') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Change Password</span>
                            </a>
                        </li>

                    @endif

                @endif



                @if(Auth::User()->isCorporate())
                    @if(Auth::User()->active == 0)

                        <li>
                            <a href="{!! route('success') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Please Pay Now</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('user.dashboard') !!}">
                                <span>Paid! Click here.</span></a>
                        </li>

                    @else

                        <li>
                            <a href="{!! route('user.dashboard') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Corporate Dashboard</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="{!! route('user.profile') !!}">
                                <i class="fa fa-truck"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="{!! route('emails.index') !!}">
                                <i class="fa fa-envelope"></i>
                                <span>My Emails</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('estamps.corporate.index') !!}">
                                <i class="fa fa-cog"></i>
                                <span>Corporate E-Stamps</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('ems.create') !!}">
                                <i class="fa fa-envelope"></i>
                                <span>EMS Courier Services</span>
                            </a>
                        </li>




                        <!-- <li class="sub-menu">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span>Post a Letter</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{!! route('estamps.create') !!}">Normal Letter</a></li>
                                <li><a href="{!! route('registers.create') !!}">Registered Mail</a></li>
                                <li><a href="{!! route('ems.create') !!}">EMS Service</a></li>
                            </ul>
                        </li> -->

                        <li>
                            <a href="{!! route('registers.create') !!}">
                            
                                <i class="fa fa-envelope"></i>
                                <span>My Registered Mail</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('estamps.contact') !!}">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>Contacts for Bulk Mail</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('deliveries.index') !!}">
                                <i class="fa fa-truck"></i>
                                <span>My Deliveries</span>
                            </a>
                        </li>


                        <li class="sub-menu">
                            <a href="{!! route('pickings.index') !!}">
                                <i class="fa fa-truck"></i>
                                <span>MY Pick-Ups</span>
                            </a>
                        </li>

                        <li>
                            <a href="{!! route('notifications.index') !!}">
                                <i class="fa fa-bell-o"></i>
                                <span>My Notifications</span>
                            </a>
                        </li>
                    @endif
                @endif
                @if(Auth::User()->isAgent())
                    <li>
                        <a href="{!! route('agent.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Agent Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('agent.create-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Create Estamps</span></a>
                    </li>

                    <li>
                        <a href="{!! route('agent.print-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Print Estamps</span></a>
                    </li>

                    <li>
                        <a href="{!! route('estamps.index') !!}">
                            <i class="fa fa-dashboard"></i> <span>View Estamps</span></a>
                    </li>

                    <li>
                        <a href="{!! route('agent.print-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Estamp from code</span></a>
                    </li>
                    <li>
                        <a href="{!! route('agent.commission') !!}">
                            <i class="fa fa-dashboard"></i> <span>Users Registered</span></a>
                    </li>
                @endif

                @if(Auth::User()->isCustomercare())
                    <li>
                        <a href="{!! route('user.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('emails.index') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Emails</span>
                        </a>
                    </li>
                @endif

                @if(Auth::User()->isClerk())
                    <li>
                        <a href="{!! route('clerk.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Clerk Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('agent.create-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Create Estamps</span></a>
                    </li>

                    <li>
                        <a href="{!! route('agent.print-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Print Estamps</span></a>
                    </li>

                    <li>
                        <a href="{!! route('estamps.index') !!}">
                            <i class="fa fa-dashboard"></i> <span>View Estamps</span></a>
                    </li>

                    <li>
                        <a href="{!! route('agent.print-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Estamp from code</span></a>
                    </li>

                    <li>
                        <a href="{!! route('clerk.landing') !!}">
                            <i class="fa fa-dashboard"></i> <span>Services</span></a>
                    </li>

                    <li>
                        <a href="{!! route('clerk.underpaid-estamp') !!}">
                            <i class="fa fa-dashboard"></i> <span>Underpaid Stamps</span></a>
                    </li>
                @endif

                @if(Auth::User()->isLogisticsOfficer())

                    <li>
                        <a href="{!! route('clerk.dashboard') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Logistics Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('dp.backoffice') !!}">
                            <i class="fa fa-dashboard"></i> 
                            <span>Backoffice Delivery</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.deliveries') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>All Deliveries</span>
                        </a>
                    </li>

                    <li>
                        <a href="{!! route('admin.pickings') !!}">
                            <i class="fa fa-dashboard"></i>
                            <span>Pick-ups</span>
                        </a>
                    </li>

                @endif

                @if(Auth::User()->isPhilately())
                    <li class="sub-menu">
                        <a href="{!! route('emails.index') !!}">
                            <i class="fa fa-envelope"></i>
                            <span>Philately Emails</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div><!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end
