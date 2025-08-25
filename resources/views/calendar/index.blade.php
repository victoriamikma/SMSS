<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Calendar - SwiftSolve</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --secondary-orange: #FF8C00;
            --light-orange: #FFE4CC;
            --dark-orange: #E55D00;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #555555;
            --text-dark: #222222;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFF5EB 0%, #FFEDDE 100%);
            color: var(--text-dark);
            line-height: 1.6;
            padding-bottom: 2rem;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .container-main {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .header-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border-left: 5px solid var(--primary-orange);
        }

        .page-title {
            font-weight: 700;
            color: var(--primary-orange);
            margin: 0;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
            background: linear-gradient(120deg, var(--secondary-orange), var(--primary-orange));
        }

        .calendar-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
            overflow: hidden;
            border: 1px solid var(--light-orange);
        }

        #calendar {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--medium-gray);
        }

        /* FullCalendar Customization */
        .fc-toolbar-title {
            font-weight: 600;
            color: var(--primary-orange);
            font-size: 1.5rem;
        }

        .fc-button {
            background: var(--primary-orange) !important;
            border: none !important;
            border-radius: 6px !important;
            transition: var(--transition);
            font-weight: 500;
        }

        .fc-button:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            background: var(--secondary-orange) !important;
        }

        .fc-button:active, .fc-button:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 0, 0.3) !important;
        }

        .fc-daygrid-event {
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .fc-event-title {
            font-weight: 600;
        }

        .fc-day-today {
            background-color: rgba(255, 107, 0, 0.1) !important;
        }

        .fc-daygrid-day-number {
            color: var(--text-dark);
            font-weight: 500;
        }

        .fc-col-header-cell {
            background-color: var(--light-orange);
        }

        .fc-col-header-cell-cushion {
            color: var(--primary-orange);
            font-weight: 600;
            padding: 8px;
        }

        .fc-day-sat, .fc-day-sun {
            background-color: rgba(255, 107, 0, 0.05);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow);
        }

        .modal-header {
            background: linear-gradient(120deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            padding: 1rem 1.5rem;
        }

        .btn-close {
            filter: invert(1);
        }

        .event-type-badge {
            display: inline-block;
            padding: 0.35rem 0.65rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            margin-right: 0.5rem;
        }

        .event-detail-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding: 0.8rem;
            border-radius: 8px;
            background-color: var(--light-gray);
        }

        .event-detail-icon {
            background: var(--primary-orange);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .event-detail-content {
            flex: 1;
        }

        .event-detail-label {
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .event-detail-value {
            color: var(--text-dark);
            font-weight: 500;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        /* Event type colors */
        .bg-exam {
            background-color: #FF6B6B !important;
        }
        
        .bg-holiday {
            background-color: #4ECDC4 !important;
        }
        
        .bg-meeting {
            background-color: #FFD166 !important;
            color: #333 !important;
        }
        
        .bg-anniversary {
            background-color: #9C27B0 !important;
        }
        
        .bg-other {
            background-color: #4361ee !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-card {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .fc-toolbar {
                flex-direction: column;
                gap: 1rem;
            }
            
            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
            }
            
            .fc-toolbar-title {
                font-size: 1.2rem;
            }
        }

        /* Animation for modal */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal.fade .modal-dialog {
            animation: fadeIn 0.3s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-orange);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-orange);
        }
        
        /* Calendar navigation improvements */
        .fc-toolbar-chunk:first-child {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .fc-prev-button, .fc-next-button {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Month view day cells */
        .fc-daygrid-day-frame {
            padding: 4px;
        }
        
        .fc-daygrid-day-top {
            justify-content: center;
        }
        
        .fc-daygrid-day-number {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 2px;
        }
        
        .fc-daygrid-day-number:hover {
            background-color: var(--light-orange);
        }
        
        .fc-day-today .fc-daygrid-day-number {
            background-color: var(--primary-orange);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    
    <!-- Main Content -->
    <div class="container-main">
        <div class="header-card">
            <h1 class="page-title">
                <i class="fas fa-calendar-days"></i> School Calendar
            </h1>
            <a href="{{ route('calendar.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add New Event
            </a>
        </div>

        <div class="calendar-card">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 id="modalEventTitle" class="mb-0">Event Title</h3>
                        <span class="event-type-badge" id="modalEventType">Academic</span>
                    </div>
                    
                    <div class="event-detail-item">
                        <div class="event-detail-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Date & Time</div>
                            <div class="event-detail-value" id="modalEventDate">May 15, 2023 • 10:00 AM - 11:30 AM</div>
                        </div>
                    </div>
                    
                    <div class="event-detail-item">
                        <div class="event-detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Location</div>
                            <div class="event-detail-value" id="modalEventLocation">Main Auditorium</div>
                        </div>
                    </div>
                    
                    <div class="event-detail-item">
                        <div class="event-detail-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="event-detail-content">
                            <div class="event-detail-label">Description</div>
                            <div class="event-detail-value" id="modalEventDescription">This is a detailed description of the event. It provides all necessary information for attendees to understand the purpose and content of the event.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="modalEditButton" href="#" class="btn btn-primary">Edit Event</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2023 SwiftSolve School System. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap5',
                events: '{{ route("calendar.api") }}',
                eventClick: function(info) {
                    const event = info.event;
                    $('#modalEventTitle').text(event.title);
                    
                    // Set event type with appropriate color
                    const typeElement = document.getElementById('modalEventType');
                    typeElement.textContent = event.extendedProps.type;
                    typeElement.className = 'event-type-badge';
                    
                    // Apply color based on event type
                    const typeColors = {
                        'exam': 'bg-exam',
                        'holiday': 'bg-holiday',
                        'meeting': 'bg-meeting',
                        'anniversary': 'bg-anniversary',
                        'other': 'bg-other'
                    };
                    typeElement.classList.add(typeColors[event.extendedProps.type] || 'bg-other');
                    
                    // Format date and time
                    const start = event.start ? new Date(event.start) : null;
                    const end = event.end ? new Date(event.end) : null;
                    
                    let dateString = '';
                    if (start) {
                        dateString = start.toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        });
                        
                        if (start.getHours() !== 0 || start.getMinutes() !== 0) {
                            dateString += ' • ' + start.toLocaleTimeString('en-US', { 
                                hour: 'numeric', 
                                minute: '2-digit' 
                            });
                            
                            if (end) {
                                dateString += ' - ' + end.toLocaleTimeString('en-US', { 
                                    hour: 'numeric', 
                                    minute: '2-digit' 
                                });
                            }
                        }
                    }
                    
                    $('#modalEventDate').text(dateString);
                    $('#modalEventLocation').text(event.extendedProps.location || 'Not specified');
                    $('#modalEventDescription').text(event.extendedProps.description || 'No description available');
                    $('#modalEditButton').attr('href', '/calendar/' + event.id + '/edit');
                    
                    var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    eventModal.show();
                },
                eventDidMount: function(info) {
                    // Set event background color based on type
                    const typeColors = {
                        'exam': '#FF6B6B',
                        'holiday': '#4ECDC4',
                        'meeting': '#FFD166',
                        'anniversary': '#9C27B0',
                        'other': '#4361ee'
                    };
                    
                    info.el.style.backgroundColor = typeColors[info.event.extendedProps.type] || '#4361ee';
                    info.el.style.borderColor = typeColors[info.event.extendedProps.type] || '#4361ee';
                }
            });
            
            calendar.render();
            
            // Add orange color to today button
            setTimeout(() => {
                const todayButton = document.querySelector('.fc-today-button');
                if (todayButton) {
                    todayButton.classList.add('btn-primary');
                    todayButton.style.backgroundColor = '';
                    todayButton.style.border = '';
                }
            }, 100);
        });
    </script>
</body>
</html>