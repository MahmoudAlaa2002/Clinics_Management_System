@extends('Backend.employees.nurses.master')

@section('title' , 'Nurse Dashboard')

@section('content')

    <style>
        .welcome-card {
            background: linear-gradient(135deg, #00A8FF, #00A8FF);
            border-radius: 18px;
            padding: 0;
            overflow: hidden;
            position: relative;
            box-shadow: 0 12px 28px rgba(0, 128, 255, 0.25);
            transition: 0.35s ease-in-out;
            width: 100%;
        }

        .welcome-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 32px rgba(0, 128, 255, 0.35);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            filter: blur(40px);
        }

        .welcome-content {
            display: flex;
            align-items: center;
            padding: 28px 32px;
            position: relative;
            z-index: 10;
        }

        .welcome-icon {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-right: 20px;
            backdrop-filter: blur(6px);
            border: 2px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
            animation: pulseGlow 2.3s infinite ease-in-out;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 12px rgba(255,255,255,0.5); }
            50% { box-shadow: 0 0 22px rgba(255,255,255,0.9); }
            100% { box-shadow: 0 0 12px rgba(255,255,255,0.5); }
        }

        .welcome-text h3 {
            margin: 0;
            color: #ffffff;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: .5px;
        }

        .welcome-text p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
            font-weight: 400;
        }
    </style>
    <div class="page-wrapper">
            <div class="content">

                {{-- Welcome --}}
                <div class="row">
                    <div class="col-12 mb-4 mt-2">
                        <div class="welcome-card">
                            <div class="welcome-content">

                                <div class="welcome-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>

                                <div class="welcome-text">
                                    <h3>Welcome, {{ Auth::user()->name }} 👋</h3>
                                    <p>We hope you have a productive and wonderful day!</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                {{-- Counts --}}
                <div class="row">

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><i class="fa fa-user-md"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $doctor_count }}</h3>
                                <span class="widget-title2">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><i class="fas fa-user-injured" aria-hidden="true"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $patient_count }}</h3>
                                <span class="widget-title3">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3" style="background-color: #814e34;"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $all_appointments }}</h3>
                                <span class="widget-title3" style="background-color: #814e34;">All Appointments <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2" style="background-color: #6f42c1;"><i class="fas fa-calendar-day"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $today_appointments }}</h3>
                                <span class="widget-title2" style="background-color: #6f42c1;">Today Appointments <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3" style="background-color: #e83e8c;"><i class="fas fa-file-invoice" aria-hidden="true"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $nurse_tasks_count }}</h3>
                                <span class="widget-title3" style="background-color: #e83e8c;">Nurse Tasks <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                </div>




            <div class="notification-box">
                <div class="msg-sidebar notifications msg-noti">
                    <div class="topnav-dropdown-header">
                        <span>Messages</span>
                    </div>
                    <div class="drop-scroll msg-list-scroll" id="msg_list">
                        <ul class="list-box">
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">R</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Richard Miles </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item new-message">
                                        <div class="list-left">
                                            <span class="avatar">J</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">John Doe</span>
                                            <span class="message-time">1 Aug</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">T</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Tarah Shropshire </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">M</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Mike Litorus</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">C</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Catherine Manseau </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">D</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Domenic Houston </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">B</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Buster Wigton </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">R</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Rolland Webber </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">C</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Claire Mapes </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">M</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Melita Faucher</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">J</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Jeffery Lalor</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">L</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Loren Gatlin</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">T</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Tarah Shropshire</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="chat.html">See all messages</a>
                    </div>
                </div>
            </div>
        </div>
@endsection
