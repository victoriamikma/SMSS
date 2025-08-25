<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SwiftSolve School System') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-orange: #FF6B00;
            --secondary-orange: #FF8C00;
            --light-orange: #FFE4CC;
            --white: #FFFFFF;
            --black: #222222;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #555555;
            --success-green: #4CAF50;
            --warning-red: #F44336;
            --info-blue: #2196F3;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        .dashboard {
            min-height: 100vh;
            background-color: var(--light-gray);
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .dashboard-header {
            background-color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-left h1 {
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .swift {
            color: var(--primary-orange);
            font-weight: 700;
        }
        
        .solve {
            color: var(--black);
            font-weight: 700;
        }
        
        .header-left p {
            color: var(--black);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            padding-right: 1.5rem;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .settings-icon {
            position: absolute;
            right: 0;
            color: var(--dark-gray);
            cursor: pointer;
        }
        
        /* Quick Stats */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            padding: 1.5rem;
        }
        
        .stat-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card.alert {
            border-left: 4px solid var(--warning-red);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .stat-icon.students {
            background-color: var(--info-blue);
        }
        
        .stat-icon.staff {
            background-color: var(--primary-orange);
        }
        
        .stat-icon.finance {
            background-color: var(--success-green);
        }
        
        .stat-icon.library {
            background-color: #9C27B0;
        }
        
        .stat-icon.attendance {
            background-color: #3F51B5;
        }
        
        .stat-icon.alert {
            background-color: var(--warning-red);
        }
        
        .stat-icon.expenses {
            background-color: #FF5722;
        }
        
        .stat-info h3 {
            font-size: 1rem;
            color: var(--black);
            opacity: 0.8;
            margin-bottom: 0.3rem;
        }
        
        .stat-info p {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--black);
        }
        
        .trend {
            font-size: 0.9rem;
            color: var(--success-green);
            font-weight: normal;
        }
        
        /* Dashboard Content */
        .dashboard-content {
            padding: 0 1.5rem 1.5rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            flex: 1;
        }
        
        @media (min-width: 992px) {
            .dashboard-content {
                grid-template-columns: 2fr 1fr;
            }
        }
        
        /* Quick Links */
        .quick-links {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .quick-links h2 {
            color: var(--black);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }
        
        .module-card {
            background-color: var(--light-orange);
            border-radius: 8px;
            padding: 1.5rem 1rem;
            text-align: center;
            text-decoration: none;
            color: var(--black);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            cursor: pointer;
        }
        
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255, 107, 0, 0.1);
            background-color: var(--secondary-orange);
            color: white;
        }
        
        .module-card:hover .module-icon {
            color: white;
        }
        
        .module-icon {
            font-size: 1.8rem;
            color: var(--primary-orange);
            margin-bottom: 0.8rem;
        }
        
        .module-card h3 {
            font-size: 1rem;
            font-weight: 500;
        }
        
        /* Make sure module cards are clickable */
        .module-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        
        /* Right Sidebar */
        .right-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        /* Upcoming Events & Recent Absences */
        .upcoming-events,
        .recent-absences {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .upcoming-events h2,
        .recent-absences h2 {
            color: var(--black);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .upcoming-events ul,
        .recent-absences ul {
            list-style: none;
        }
        
        .upcoming-events li {
            padding: 1rem 0;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            flex-direction: column;
        }
        
        .recent-absences li {
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--medium-gray);
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            align-items: center;
        }
        
        .event-date {
            font-weight: 600;
            color: var(--primary-orange);
            font-size: 0.9rem;
        }
        
        .event-name,
        .student-name {
            color: var(--black);
            margin-top: 0.3rem;
        }
        
        .student-class {
            color: var(--dark-gray);
            font-size: 0.9rem;
            text-align: center;
        }
        
        .absence-days {
            color: var(--warning-red);
            font-weight: 600;
            text-align: right;
        }
        
        /* Footer */
        .dashboard-footer {
            background-color: var(--white);
            padding: 1rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--black);
            opacity: 0.7;
            border-top: 1px solid var(--medium-gray);
            margin-top: auto;
        }
        
        .dashboard-footer p {
            margin-bottom: 0.3rem;
        }
        
        /* Alert styles */
        .alert {
            padding: 12px 16px;
            border-radius: 4px;
            margin: 10px 0;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #f44336;
        }
    </style>
</head>
<body class="dashboard">
    @if(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
    @endif
    
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-left">
            <h1>
                <span class="swift">SWIFT</span>
                <span class="solve">SOLVE</span> SCHOOL SYSTEM
            </h1>
            <p>Kampala, Uganda | +256 702 064 779</p>
        </div>
        <div class="header-right">
            <div class="user-profile">
                <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="User" />
                <span>{{ Auth::user()->name }}</span>
                <a href="{{ route('profile.show') }}" class="settings-icon">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-card">
            <div class="stat-icon students">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Students</h3>
                @php
                    try {
                        $studentCount = App\Models\Student::count();
                    } catch (Exception $e) {
                        $studentCount = 0;
                        Log::error('Error counting students: ' . $e->getMessage());
                    }
                @endphp
                <p>{{ number_format($studentCount) }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon staff">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-info">
                <h3>Staff</h3>
                @php
                    try {
                        $staffCount = App\Models\Staff::count();
                    } catch (Exception $e) {
                        $staffCount = 0;
                        Log::error('Error counting staff: ' . $e->getMessage());
                    }
                @endphp
                <p>{{ number_format($staffCount) }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon finance">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3>Fees Collected</h3>
                @php
                    try {
                        $feesCollected = App\Models\Payment::sum('amount');
                    } catch (Exception $e) {
                        $feesCollected = 0;
                        Log::error('Error calculating fees: ' . $e->getMessage());
                    }
                @endphp
                <p>UGX {{ number_format($feesCollected) }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon expenses">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-info">
                <h3>Expenses</h3>
                @php
                    try {
                        // Assuming you have an Expense model
                        $expenseCount = class_exists('App\Models\Expense') ? App\Models\Expense::count() : 0;
                        $expenseTotal = class_exists('App\Models\Expense') ? App\Models\Expense::sum('amount') : 0;
                    } catch (Exception $e) {
                        $expenseCount = 0;
                        $expenseTotal = 0;
                        Log::error('Error calculating expenses: ' . $e->getMessage());
                    }
                @endphp
                <p>{{ number_format($expenseCount) }} (UGX {{ number_format($expenseTotal) }})</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon library">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-info">
                <h3>Books Borrowed</h3>
                @php
                    try {
                        $booksBorrowed = App\Models\LibraryTransaction::whereNull('returned_at')->count();
                    } catch (Exception $e) {
                        $booksBorrowed = 0;
                        Log::error('Error counting borrowed books: ' . $e->getMessage());
                    }
                @endphp
                <p>{{ number_format($booksBorrowed) }}</p>
            </div>
        </div>

        @php
            $attendancePercentage = 0;
            $trend = 0;
            
            try {
                $attendance = App\Models\Attendance::whereDate('date', today())->first();
                if ($attendance && $attendance->total_students > 0) {
                    $attendancePercentage = $attendance->present_count / $attendance->total_students * 100;
                    $trend = $attendancePercentage - ($attendance->previous_day_percentage ?? 0);
                }
            } catch (Exception $e) {
                Log::error('Error calculating attendance: ' . $e->getMessage());
            }
        @endphp

        <div class="stat-card">
            <div class="stat-icon attendance">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>Today's Attendance</h3>
                <p>{{ round($attendancePercentage) }}% 
                    @if($trend != 0)
                    <span class="trend" style="color: {{ $trend > 0 ? 'var(--success-green)' : 'var(--warning-red)' }};">
                        {{ $trend > 0 ? '+'.round($trend) : round($trend) }}%
                    </span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Quick Links - All Modules -->
        <div class="quick-links">
            <h2>
                <i class="fas fa-home"></i> System Modules
            </h2>
            <div class="modules-grid">
                <a href="{{ route('students.index') }}" class="module-card" data-route="students">
                    <div class="module-icon"><i class="fas fa-users"></i></div>
                    <h3>Students</h3>
                </a>
                <a href="{{ route('academics.index') }}" class="module-card" data-route="academics">
                    <div class="module-icon"><i class="fas fa-book"></i></div>
                    <h3>Academics</h3>
                </a>
                <a href="{{ route('finance.index') }}" class="module-card" data-route="finance">
                    <div class="module-icon"><i class="fas fa-dollar-sign"></i></div>
                    <h3>Finance</h3>
                </a>
                <a href="{{ route('expenses.index') }}" class="module-card" data-route="expenses">
                    <div class="module-icon"><i class="fas fa-receipt"></i></div>
                    <h3>Expenses</h3>
                </a>
                <a href="{{ route('staff.index') }}" class="module-card" data-route="staff">
    <div class="module-icon"><i class="fas fa-user-plus"></i></div>
    <h3>Staff</h3>
</a>
                <a href="{{ route('library.index') }}" class="module-card" data-route="library">
                    <div class="module-icon"><i class="fas fa-book-open"></i></div>
                    <h3>Library</h3>
                </a>
                <a href="{{ route('calendar.index') }}" class="module-card" data-route="calendar">
                    <div class="module-icon"><i class="fas fa-calendar"></i></div>
                    <h3>Calendar</h3>
                </a>
                <a href="{{ route('reports.index') }}" class="module-card" data-route="reports">
                    <div class="module-icon"><i class="fas fa-chart-bar"></i></div>
                    <h3>Reports</h3>
                </a>
                <a href="{{ route('security.index') }}" class="module-card" data-route="security">
                    <div class="module-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Security</h3>
                </a>
                <a href="{{ route('applications.index') }}" class="module-card" data-route="applications">
                    <div class="module-icon"><i class="fas fa-server"></i></div>
                    <h3>Applications</h3>
                </a>
                <a href="{{ route('fees.index') }}" class="module-card" data-route="fees">
                    <div class="module-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <h3>Fees</h3>
                </a>
                <a href="{{ route('messaging.index') }}" class="module-card" data-route="messaging">
                    <div class="module-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Messaging</h3>
                </a>
                <a href="{{ route('attendance.index') }}" class="module-card" data-route="attendance">
                    <div class="module-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Attendance</h3>
                </a>
                <a href="{{ route('timetable.index') }}" class="module-card" data-route="timetable">
                    <div class="module-icon"><i class="fas fa-clock"></i></div>
                    <h3>Timetable</h3>
                </a>
                <a href="{{ route('exams.index') }}" class="module-card" data-route="exams">
                    <div class="module-icon"><i class="fas fa-edit"></i></div>
                    <h3>Exams</h3>
                </a>
                <a href="{{ route('parents.index') }}" class="module-card" data-route="parents">
                    <div class="module-icon"><i class="fas fa-users"></i></div>
                    <h3>Parents</h3>
                </a>
                <a href="{{ route('transport.index') }}" class="module-card" data-route="transport">
                    <div class="module-icon"><i class="fas fa-truck"></i></div>
                    <h3>Transport</h3>
                </a>
                <a href="{{ route('health.index') }}" class="module-card" data-route="health">
                    <div class="module-icon"><i class="fas fa-heart"></i></div>
                    <h3>Health</h3>
                </a>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="right-sidebar">
            <!-- Upcoming Events -->
            <div class="upcoming-events">
                <h2>
                    <i class="fas fa-calendar"></i> Upcoming Events
                </h2>
                <ul>
                    @php
                        use App\Models\Event;
                        $upcomingEvents = Event::where('start_date', '>=', now())
                            ->orderBy('start_date')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @forelse($upcomingEvents as $event)
                        <li>
                            <div class="event-date">
                                {{ $event->start_date->format('M j') }}
                                @if($event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d'))
                                    - {{ $event->end_date->format('M j') }}
                                @endif
                            </div>
                            <div class="event-name">{{ $event->name }}</div>
                            <div class="event-type-badge" style="background-color: {{ App\Http\Controllers\CalendarController::getEventColor($event->type) }}; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">
                                {{ ucfirst($event->type) }}
                            </div>
                        </li>
                    @empty
                        <li>No upcoming events</li>
                    @endforelse
                </ul>
                @if(count($upcomingEvents) > 0)
                    <div style="text-align: center; margin-top: 0.5rem;">
                        <a href="{{ route('calendar.index') }}" style="color: var(--primary-orange); text-decoration: none; font-size: 0.9rem;">View Full Calendar</a>
                    </div>
                @endif
            </div>

            <!-- Recent Absences -->
            <div class="recent-absences">
                <h2>
                    <i class="fas fa-exclamation-circle"></i> Recent Absences
                </h2>
                <ul>
                    @php
                        $recentAbsences = [];
                        try {
                            $recentAbsences = App\Models\Attendance::with('student')
                                ->where('status', 'absent')
                                ->orderByDesc('date')
                                ->limit(2)
                                ->get();
                        } catch (Exception $e) {
                            Log::error('Error fetching absences: ' . $e->getMessage());
                        }
                    @endphp
                    
                    @forelse($recentAbsences as $absence)
                        <li>
                            <div class="student-name">{{ $absence->student->name ?? 'N/A' }}</div>
                            <div class="student-class">{{ $absence->student->class->name ?? 'N/A' }}</div>
                            <div class="absence-days">{{ $absence->days_absent ?? 0 }} days</div>
                        </li>
                    @empty
                        <li>No recent absences</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="dashboard-footer">
        <p>© {{ date('Y') }} Swift Solve Tech Solutions | hello@swiftsolvetech.ug</p>
        <p>System Version: 1.0.0 | Last Updated: {{ date('d/m/Y') }}</p>
    </footer>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Auto-refresh dashboard every 5 minutes -->
   
</body>
</html>