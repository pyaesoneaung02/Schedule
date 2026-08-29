@extends('admin.layouts.master')

@section('content')
    <style>
        /* =========================================================
       PREMIUM SOFT GLASS DASHBOARD
       ========================================================= */

        :root {
            --bg: #f4f7fb;
            --surface: rgba(255, 255, 255, .78);
            --white: #ffffff;

            --text: #263247;
            --muted: #8d99aa;

            --primary: #6674f5;
            --purple: #8b70e8;
            --cyan: #45b9cf;
            --green: #47b98b;
            --orange: #e7a24d;

            --shadow:
                10px 10px 28px rgba(163, 177, 198, .18),
                -10px -10px 28px rgba(255, 255, 255, .95);

            --soft-shadow:
                5px 5px 14px rgba(163, 177, 198, .16),
                -5px -5px 14px rgba(255, 255, 255, .9);
        }


        /* =========================================================
       MAIN
       ========================================================= */

        .showcase-dashboard {

            min-height: calc(100vh - 70px);

            padding: 17px 24px 25px;

            background:

                radial-gradient(circle at 8% 8%,
                    rgba(102, 116, 245, .08),
                    transparent 23%),

                radial-gradient(circle at 92% 20%,
                    rgba(69, 185, 207, .07),
                    transparent 22%),

                radial-gradient(circle at 60% 100%,
                    rgba(139, 112, 232, .06),
                    transparent 25%),

                var(--bg);

        }


        /* =========================================================
       HEADER
       ========================================================= */

        .showcase-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 17px;

        }


        .brand-area {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .brand-orb {

            position: relative;

            width: 45px;

            height: 45px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 15px;

            color: #fff;

            background:

                linear-gradient(145deg,
                    #7784fa,
                    #5968df);

            box-shadow:

                6px 6px 16px rgba(102, 116, 245, .25),

                -5px -5px 14px rgba(255, 255, 255, .9);

        }


        .brand-orb::after {

            content: "";

            position: absolute;

            width: 12px;

            height: 12px;

            right: -3px;

            top: -3px;

            border-radius: 50%;

            background: #45b9cf;

            border: 3px solid var(--bg);

        }


        .brand-orb i {

            font-size: 15px;

        }


        .header-kicker {

            margin-bottom: 3px;

            color: #9aa6b7;

            font-size: 7px;

            font-weight: 900;

            letter-spacing: 1.7px;

        }


        .header-title {

            margin: 0;

            color: var(--text);

            font-size: 24px;

            font-weight: 900;

            letter-spacing: -.7px;

        }


        .header-title span {

            color: var(--primary);

        }


        .header-description {

            margin: 3px 0 0;

            color: #a5afbd;

            font-size: 7px;

        }


        .header-status {

            display: flex;

            align-items: center;

            gap: 8px;

            padding: 8px 12px;

            border-radius: 12px;

            background: rgba(255, 255, 255, .65);

            border: 1px solid rgba(255, 255, 255, .9);

            box-shadow: var(--soft-shadow);

            color: #8995a7;

            font-size: 6px;

            font-weight: 900;

            letter-spacing: .8px;

        }


        .online-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: #47b98b;

            box-shadow:

                0 0 0 4px rgba(71, 185, 139, .1);

        }


        /* =========================================================
       STATS
       ========================================================= */

        .stats-wrapper {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 13px;

            margin-bottom: 15px;

        }


        .metric-card {

            position: relative;

            min-height: 104px;

            overflow: hidden;

            padding: 14px;

            border-radius: 20px;

            background: var(--surface);

            border: 1px solid rgba(255, 255, 255, .8);

            box-shadow: var(--shadow);

            backdrop-filter: blur(10px);

            transition: .25s ease;

        }


        .metric-card:hover {

            transform: translateY(-4px);

        }


        .metric-glow {

            position: absolute;

            width: 85px;

            height: 85px;

            right: -28px;

            bottom: -38px;

            border-radius: 50%;

            opacity: .08;

        }


        .metric-blue .metric-glow {

            background: var(--primary);

        }


        .metric-green .metric-glow {

            background: var(--green);

        }


        .metric-purple .metric-glow {

            background: var(--purple);

        }


        .metric-orange .metric-glow {

            background: var(--orange);

        }


        .metric-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

        }


        .metric-icon {

            width: 34px;

            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            background: #f5f7fb;

            box-shadow:

                inset 2px 2px 5px rgba(163, 177, 198, .15),

                inset -3px -3px 6px rgba(255, 255, 255, .95);

            font-size: 12px;

        }


        .metric-blue .metric-icon {

            color: var(--primary);

        }


        .metric-green .metric-icon {

            color: var(--green);

        }


        .metric-purple .metric-icon {

            color: var(--purple);

        }


        .metric-orange .metric-icon {

            color: var(--orange);

        }


        .metric-code {

            color: #c0c7d2;

            font-size: 6px;

            font-weight: 900;

            letter-spacing: 1px;

        }


        .metric-label {

            margin-top: 10px;

            color: #8996a8;

            font-size: 7px;

            font-weight: 900;

            text-transform: uppercase;

            letter-spacing: .8px;

        }


        .metric-number {

            position: absolute;

            right: 15px;

            bottom: 10px;

            color: var(--text);

            font-size: 25px;

            font-weight: 900;

            line-height: 1;

        }


        /* =========================================================
       MAIN WORKSPACE
       ========================================================= */

        .workspace {

            display: grid;

            grid-template-columns:
                minmax(0, 1.65fr) minmax(270px, .75fr);

            gap: 15px;

        }


        /* =========================================================
       GLASS PANEL
       ========================================================= */

        .glass-panel {

            position: relative;

            min-height: 320px;

            overflow: hidden;

            border-radius: 23px;

            background: rgba(255, 255, 255, .72);

            border: 1px solid rgba(255, 255, 255, .85);

            box-shadow: var(--shadow);

            backdrop-filter: blur(12px);

        }


        .glass-panel::before {

            content: "";

            position: absolute;

            width: 150px;

            height: 150px;

            right: -70px;

            top: -70px;

            border-radius: 50%;

            background: rgba(102, 116, 245, .035);

        }


        .panel-header {

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 16px 18px 5px;

        }


        .panel-heading {

            display: flex;

            align-items: center;

            gap: 9px;

        }


        .panel-icon {

            width: 31px;

            height: 31px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            color: var(--primary);

            background: #f5f7fc;

            box-shadow:

                inset 2px 2px 5px rgba(163, 177, 198, .15),

                inset -2px -2px 5px rgba(255, 255, 255, .9);

            font-size: 10px;

        }


        .panel-title {

            margin: 0;

            color: var(--text);

            font-size: 10px;

            font-weight: 900;

        }


        .panel-subtitle {

            margin: 3px 0 0;

            color: #a0aaba;

            font-size: 6px;

        }


        .panel-badge {

            padding: 5px 8px;

            border-radius: 8px;

            color: var(--primary);

            background: #f5f7fc;

            box-shadow:

                inset 2px 2px 4px rgba(163, 177, 198, .12),

                inset -2px -2px 4px rgba(255, 255, 255, .9);

            font-size: 5px;

            font-weight: 900;

            letter-spacing: .8px;

        }


        /* =========================================================
       LINE CHART
       ========================================================= */

        .line-area {

            height: 260px;

            padding: 3px 14px 14px;

            background: transparent;

        }


        /* =========================================================
       DONUT
       ========================================================= */

        .donut-area {

            position: relative;

            height: 205px;

            padding: 2px 18px;

            background: transparent;

        }


        .donut-center {

            position: absolute;

            left: 50%;

            top: 48%;

            transform: translate(-50%, -50%);

            text-align: center;

            pointer-events: none;

        }


        .donut-total {

            color: var(--text);

            font-size: 28px;

            font-weight: 900;

            line-height: 1;

        }


        .donut-caption {

            margin-top: 5px;

            color: #9ba6b5;

            font-size: 5px;

            font-weight: 900;

            letter-spacing: 1px;

        }


        /* =========================================================
       LEGEND
       ========================================================= */

        .legend {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 7px;

            padding: 0 18px 16px;

        }


        .legend-item {

            display: flex;

            align-items: center;

            gap: 6px;

            padding: 7px 8px;

            border-radius: 9px;

            background: #f5f7fb;

            box-shadow:

                inset 2px 2px 5px rgba(163, 177, 198, .1),

                inset -2px -2px 5px rgba(255, 255, 255, .85);

        }


        .legend-dot {

            width: 6px;

            height: 6px;

            border-radius: 50%;

        }


        .legend-name {

            color: #8995a6;

            font-size: 5px;

            font-weight: 900;

        }


        /* =========================================================
       PROJECT FOOTER
       ========================================================= */

        .project-strip {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 15px;

            padding: 10px 14px;

            border-radius: 14px;

            background: rgba(255, 255, 255, .6);

            border: 1px solid rgba(255, 255, 255, .8);

            box-shadow: var(--soft-shadow);

        }


        .project-left {

            display: flex;

            align-items: center;

            gap: 8px;

        }


        .project-mark {

            width: 24px;

            height: 24px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            color: var(--primary);

            background: #f5f7fb;

            box-shadow: var(--soft-shadow);

            font-size: 8px;

        }


        .project-title {

            color: #68768a;

            font-size: 6px;

            font-weight: 900;

            letter-spacing: .7px;

        }


        .project-subtitle {

            margin-top: 2px;

            color: #a5afbc;

            font-size: 5px;

        }


        .project-status {

            display: flex;

            align-items: center;

            gap: 5px;

            color: #9aa5b5;

            font-size: 5px;

            font-weight: 900;

        }


        .project-live {

            width: 5px;

            height: 5px;

            border-radius: 50%;

            background: var(--green);

        }


        /* =========================================================
       RESPONSIVE
       ========================================================= */

        @media(max-width: 950px) {

            .stats-wrapper {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .workspace {

                grid-template-columns: 1fr;

            }

        }


        @media(max-width: 600px) {

            .showcase-dashboard {

                padding: 14px;

            }

            .header-status {

                display: none;

            }

            .header-title {

                font-size: 20px;

            }

            .stats-wrapper {

                gap: 10px;

            }

            .metric-card {

                min-height: 98px;

            }

            .project-status {

                display: none;

            }

        }
    </style>


    <div class="showcase-dashboard">


        <!-- =====================================================
             HEADER
             ===================================================== -->

        <div class="showcase-header">


            <div class="brand-area">


                <div class="brand-orb">

                    <i class="fa-solid fa-building-columns"></i>

                </div>


                <div>

                    <div class="header-kicker">

                        AUTO SCHEDULE MANAGEMENT SYSTEM

                    </div>


                    <h1 class="header-title">

                        Academic
                        <span>Overview</span>

                    </h1>


                    <p class="header-description">

                        Smart academic resource and timetable management

                    </p>

                </div>

            </div>


            <div class="header-status">

                <span class="online-dot"></span>

                SYSTEM ONLINE

            </div>


        </div>



        <!-- =====================================================
             METRICS
             ===================================================== -->

        <div class="stats-wrapper">


            <!-- Teachers -->

            <div class="metric-card metric-blue">

                <div class="metric-glow"></div>


                <div class="metric-top">

                    <div class="metric-icon">

                        <i class="fa-solid fa-chalkboard-user"></i>

                    </div>


                    <div class="metric-code">
                        01
                    </div>

                </div>


                <div class="metric-label">
                    Teachers
                </div>


                <div class="metric-number">
                    {{ $teacherCount }}
                </div>

            </div>



            <!-- Years -->

            <div class="metric-card metric-green">

                <div class="metric-glow"></div>


                <div class="metric-top">

                    <div class="metric-icon">

                        <i class="fa-solid fa-graduation-cap"></i>

                    </div>


                    <div class="metric-code">
                        02
                    </div>

                </div>


                <div class="metric-label">
                    Class Years
                </div>


                <div class="metric-number">
                    {{ $yearCount }}
                </div>

            </div>



            <!-- Departments -->

            <div class="metric-card metric-purple">

                <div class="metric-glow"></div>


                <div class="metric-top">

                    <div class="metric-icon">

                        <i class="fa-solid fa-building-columns"></i>

                    </div>


                    <div class="metric-code">
                        03
                    </div>

                </div>


                <div class="metric-label">
                    Departments
                </div>


                <div class="metric-number">
                    {{ $departmentCount }}
                </div>

            </div>



            <!-- Subjects -->

            <div class="metric-card metric-orange">

                <div class="metric-glow"></div>


                <div class="metric-top">

                    <div class="metric-icon">

                        <i class="fa-solid fa-book-open"></i>

                    </div>


                    <div class="metric-code">
                        04
                    </div>

                </div>


                <div class="metric-label">
                    Subjects
                </div>


                <div class="metric-number">
                    {{ $subjectCount }}
                </div>

            </div>


        </div>



        <!-- =====================================================
             WORKSPACE
             ===================================================== -->

        <div class="workspace">


            <!-- =================================================
                 ANALYTICS
                 ================================================= -->

            <div class="glass-panel">


                <div class="panel-header">


                    <div class="panel-heading">


                        <div class="panel-icon">

                            <i class="fa-solid fa-chart-line"></i>

                        </div>


                        <div>

                            <h3 class="panel-title">

                                Academic Activity

                            </h3>


                            <p class="panel-subtitle">

                                University resource comparison

                            </p>

                        </div>


                    </div>


                    <div class="panel-badge">

                        ANALYTICS

                    </div>


                </div>


                <div class="line-area">

                    <canvas id="academicLineChart"></canvas>

                </div>


            </div>



            <!-- =================================================
                 RESOURCE MIX
                 ================================================= -->

            <div class="glass-panel">


                <div class="panel-header">


                    <div class="panel-heading">


                        <div class="panel-icon">

                            <i class="fa-solid fa-chart-pie"></i>

                        </div>


                        <div>

                            <h3 class="panel-title">

                                Resource Mix

                            </h3>


                            <p class="panel-subtitle">

                                Academic distribution

                            </p>

                        </div>


                    </div>


                    <div class="panel-badge">

                        RATIO

                    </div>


                </div>


                <div class="donut-area">


                    <canvas id="resourceDoughnut"></canvas>


                    <div class="donut-center">


                        <div class="donut-total">

                            {{ $teacherCount + $yearCount + $departmentCount + $subjectCount }}

                        </div>


                        <div class="donut-caption">

                            TOTAL RESOURCES

                        </div>


                    </div>


                </div>



                <div class="legend">


                    <div class="legend-item">

                        <span class="legend-dot" style="background:#6674f5">
                        </span>

                        <span class="legend-name">
                            Teachers
                        </span>

                    </div>


                    <div class="legend-item">

                        <span class="legend-dot" style="background:#47b98b">
                        </span>

                        <span class="legend-name">
                            Years
                        </span>

                    </div>


                    <div class="legend-item">

                        <span class="legend-dot" style="background:#8b70e8">
                        </span>

                        <span class="legend-name">
                            Departments
                        </span>

                    </div>


                    <div class="legend-item">

                        <span class="legend-dot" style="background:#e7a24d">
                        </span>

                        <span class="legend-name">
                            Subjects
                        </span>

                    </div>


                </div>


            </div>


        </div>



        <!-- =====================================================
             PROJECT STRIP
             ===================================================== -->

        <div class="project-strip">


            <div class="project-left">


                <div class="project-mark">

                    <i class="fa-solid fa-wand-magic-sparkles"></i>

                </div>


                <div>

                    <div class="project-title">

                        AUTO SCHEDULE MANAGEMENT SYSTEM

                    </div>


                    <div class="project-subtitle">

                        Resource management • Timetable generation • Academic analytics

                    </div>

                </div>


            </div>


            <div class="project-status">

                <span class="project-live"></span>

                READY

            </div>


        </div>


    </div>



    <!-- =========================================================
         CHART.JS
         ========================================================= -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {


                /* =================================================
                   CURRENT DATA
                   ================================================= */

                const teachers =
                    {{ $teacherCount }};

                const years =
                    {{ $yearCount }};

                const departments =
                    {{ $departmentCount }};

                const subjects =
                    {{ $subjectCount }};



                /* =================================================
                   LINE CHART
                   ================================================= */

                const lineCanvas =
                    document.getElementById(
                        'academicLineChart'
                    );


                if (lineCanvas) {

                    new Chart(
                        lineCanvas, {

                            type: 'line',


                            data: {

                                labels: [

                                    'Teachers',

                                    'Class Years',

                                    'Departments',

                                    'Subjects'

                                ],


                                datasets: [{

                                    data: [

                                        teachers,

                                        years,

                                        departments,

                                        subjects

                                    ],


                                    borderColor: '#6674f5',


                                    backgroundColor: 'transparent',


                                    fill: false,


                                    borderWidth: 3,


                                    tension: .45,


                                    pointRadius: 5,


                                    pointHoverRadius: 8,


                                    pointBackgroundColor: '#f4f7fb',


                                    pointBorderColor: '#6674f5',


                                    pointBorderWidth: 3

                                }]

                            },


                            options: {

                                responsive: true,


                                maintainAspectRatio: false,


                                animation: {

                                    duration: 1100,

                                    easing: 'easeOutQuart'

                                },


                                interaction: {

                                    intersect: false,

                                    mode: 'index'

                                },


                                plugins: {

                                    legend: {

                                        display: false

                                    },


                                    tooltip: {

                                        backgroundColor: '#263247',

                                        titleColor: '#ffffff',

                                        bodyColor: '#dbe3ee',

                                        padding: 10,

                                        cornerRadius: 9,

                                        displayColors: false

                                    }

                                },


                                scales: {

                                    x: {

                                        grid: {

                                            display: false

                                        },


                                        border: {

                                            display: false

                                        },


                                        ticks: {

                                            color: '#96a2b2',

                                            font: {

                                                size: 8,

                                                weight: '600'

                                            }

                                        }

                                    },


                                    y: {

                                        beginAtZero: true,


                                        grid: {

                                            color: 'rgba(148,163,184,.12)',

                                            drawTicks: false

                                        },


                                        border: {

                                            display: false

                                        },


                                        ticks: {

                                            precision: 0,

                                            color: '#96a2b2',

                                            padding: 8,

                                            font: {

                                                size: 8

                                            }

                                        }

                                    }

                                }

                            }

                        }
                    );

                }



                /* =================================================
                   DOUGHNUT
                   ================================================= */

                const donutCanvas =
                    document.getElementById(
                        'resourceDoughnut'
                    );


                if (donutCanvas) {

                    new Chart(
                        donutCanvas, {

                            type: 'doughnut',


                            data: {

                                labels: [

                                    'Teachers',

                                    'Years',

                                    'Departments',

                                    'Subjects'

                                ],


                                datasets: [{

                                    data: [

                                        teachers,

                                        years,

                                        departments,

                                        subjects

                                    ],


                                    backgroundColor: [

                                        '#6674f5',

                                        '#47b98b',

                                        '#8b70e8',

                                        '#e7a24d'

                                    ],


                                    borderWidth: 0,


                                    spacing: 5,


                                    hoverOffset: 8

                                }]

                            },


                            options: {

                                responsive: true,


                                maintainAspectRatio: false,


                                cutout: '79%',


                                animation: {

                                    duration: 1100

                                },


                                plugins: {

                                    legend: {

                                        display: false

                                    },


                                    tooltip: {

                                        backgroundColor: '#263247',

                                        titleColor: '#ffffff',

                                        bodyColor: '#dbe3ee',

                                        padding: 9,

                                        cornerRadius: 8

                                    }

                                }

                            }

                        }
                    );

                }

            }

        );
    </script>
@endsection
