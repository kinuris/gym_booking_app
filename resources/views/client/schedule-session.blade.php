<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Schedule Session</title>

    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .calendar-day {
            padding: 8px;
            text-align: center;
            background-color: rgba(75, 85, 99, 0.5);
            cursor: pointer;
            border-radius: 4px;
        }

        .calendar-day:hover {
            background-color: rgba(59, 130, 246, 0.5);
        }

        .selected-start {
            background-color: rgb(59, 130, 246) !important;
        }

        .selected-end {
            background-color: rgb(16, 185, 129) !important;
        }

        .selected-between {
            background-color: rgba(59, 130, 246, 0.3) !important;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-screen">
    @include('client.nav')
    <div class="max-w-xl mx-auto my-12 bg-gray-800/50 backdrop-blur-sm shadow-2xl rounded-xl overflow-hidden border border-gray-700">
        <div class="flex justify-center mt-8">
            <div class="relative">
                <img class="object-cover w-48 h-48 rounded-full shadow-xl border-4 border-gray-700"
                    src="{{ asset('storage/' . $instructor->profile_image) }}"
                    alt="Instructor Profile Image">
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-600 px-4 py-1 rounded-full text-sm font-semibold">
                    Instructor
                </div>
            </div>
        </div>
        <div class="p-8">
            <h2 class="text-center text-2xl font-bold text-blue-400">{{ $instructor->fullname }}</h2>
            <p class="text-center text-gray-400 mt-2 italic">{{ $instructor->bio }}</p>
        </div>

        <div class="px-8 pb-8">
            <div class="flex justify-center mb-6 gap-4">
                <button id="monthlyButton" class="bg-gray-700 hover:bg-blue-600 transition-colors duration-300 flex-1 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                    Monthly Plan
                </button>
                <button id="hourlyButton" class="bg-gray-700 hover:bg-blue-600 transition-colors duration-300 flex-1 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                    Hourly Plan
                </button>
            </div>

            @if($errors->has('start_date') || $errors->has('end_date'))
                <div class="bg-red-900/50 border border-red-500 rounded-lg p-4 mb-4">
                    @if($errors->has('start_date'))
                        <div class="flex items-center gap-2 text-red-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $errors->first('start_date') }}</span>
                        </div>
                    @endif
                    @if($errors->has('end_date'))
                        <div class="flex items-center gap-2 text-red-400 @if($errors->has('start_date')) mt-2 @endif">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $errors->first('end_date') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <div id="calendar" class="mt-6 p-4 bg-gray-700/50 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <button id="prevMonth" class="text-gray-400 hover:text-white">&lt; Prev</button>
                    <h3 id="monthYear" class="text-lg font-bold"></h3>
                    <button id="nextMonth" class="text-gray-400 hover:text-white">Next &gt;</button>
                </div>
                <div class="calendar" id="calendarGrid"></div>
            </div>

            <div id="monthlyRateForm" class="rate-form hidden space-y-6 mt-4">
                <h3 class="text-center text-xl font-bold text-blue-400">Monthly Rate
                    <span class="text-green-400">({{ number_format($instructor->monthly_rate, 2) }} PHP)</span>
                </h3>
                <form action="/session/schedule/monthly" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <input type="hidden" name="start_date" class="bg-blue-600">
                    <input type="hidden" name="end_date">
                    <!-- <div class="space-y-2">
                        <label for="monthly_rate" class="block text-gray-300 font-medium">Duration (In Months)</label>
                        <input type="text" id="monthly_rate" name="duration"
                            class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div> -->
                    <input type="hidden" name="location" value="N/A">
                    <!-- <div class="space-y-2">
                        <label for="meeting_place" class="block text-gray-300 font-medium">Meeting Place</label>
                        <input type="text" id="meeting_place" name="location" 
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div> -->
                    <div class="flex justify-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-300">
                            Schedule Session
                        </button>
                    </div>
                </form>
            </div>

            <div id="hourlyRateForm" class="rate-form hidden space-y-6 mt-4">
                <h3 class="text-center text-xl font-bold text-blue-400">Hourly Rate
                    <span class="text-green-400">({{ number_format($instructor->hourly_rate, 2) }} PHP)</span>
                </h3>
                <form action="/session/schedule/hourly" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <input type="hidden" name="start_date">
                    <input type="hidden" name="end_date">
                    <!-- <div class="space-y-2">
                        <label for="hourly_rate" class="block text-gray-300 font-medium">Duration (In Hours)</label>
                        <input type="text" id="hourly_rate" name="duration"
                            class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div> -->
                    <input type="hidden" name="location" value="N/A">
                    <!-- <div class="space-y-2">
                        <label for="meeting_place" class="block text-gray-300 font-medium">Meeting Place</label>
                        <input type="text" id="meeting_place" name="location" 
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div> -->
                    <div class="flex justify-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-300">
                            Schedule Session
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('monthlyButton').addEventListener('click', function() {
            document.getElementById('monthlyRateForm').classList.remove('hidden');
            document.getElementById('hourlyRateForm').classList.add('hidden');
            this.classList.add('bg-blue-600');
            this.classList.remove('bg-gray-700');
            document.getElementById('hourlyButton').classList.remove('bg-blue-600');
            document.getElementById('hourlyButton').classList.add('bg-gray-700');
        });

        document.getElementById('hourlyButton').addEventListener('click', function() {
            document.getElementById('hourlyRateForm').classList.remove('hidden');
            document.getElementById('monthlyRateForm').classList.add('hidden');
            this.classList.add('bg-blue-600');
            this.classList.remove('bg-gray-700');
            document.getElementById('monthlyButton').classList.remove('bg-blue-600');
            document.getElementById('monthlyButton').classList.add('bg-gray-700');
        });
    </script>

    <script>
        let currentDate = new Date();
        let startDate = null;
        let endDate = null;
        let today = new Date(); // Add this line to store today's date

        function renderCalendar() {
            const grid = document.getElementById('calendarGrid');
            grid.innerHTML = '';

            document.getElementById('monthYear').textContent =
                currentDate.toLocaleString('default', {
                    month: 'long',
                    year: 'numeric'
                });

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

            for (let i = 0; i < firstDay.getDay(); i++) {
                grid.appendChild(document.createElement('div'));
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;

                const currentDateObj = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);

                // Disable past dates
                if (currentDateObj < today) {
                    dayElement.style.opacity = '0.5';
                    dayElement.style.cursor = 'not-allowed';
                    grid.appendChild(dayElement);
                    continue;
                }

                if (startDate && endDate && currentDateObj > startDate && currentDateObj < endDate) {
                    dayElement.classList.add('selected-between');
                }
                if (startDate && currentDateObj.getTime() === startDate.getTime()) {
                    dayElement.classList.add('selected-start');
                }
                if (endDate && currentDateObj.getTime() === endDate.getTime()) {
                    dayElement.classList.add('selected-end');
                }

                dayElement.addEventListener('click', () => {
                    // Prevent selecting past dates
                    if (currentDateObj < today) {
                        return;
                    }

                    if (!startDate) {
                        startDate = currentDateObj;
                        clearCalendarSelection();
                        dayElement.classList.add('selected-start');
                    } else if (!endDate) {
                        if (currentDateObj < startDate) {
                            // If selected date is before start date, move start date
                            startDate = currentDateObj;
                            clearCalendarSelection();
                            dayElement.classList.add('selected-start');
                        } else {
                            endDate = currentDateObj;
                            dayElement.classList.add('selected-end');
                            highlightDateRange();
                        }
                    } else {
                        clearCalendarSelection();
                        startDate = currentDateObj;
                        endDate = null;
                        dayElement.classList.add('selected-start');
                    }

                    document.querySelectorAll('[name="start_date"]').forEach(input => {
                        if (startDate) {
                            let adjustedStartDate = new Date(startDate);
                            adjustedStartDate.setDate(adjustedStartDate.getDate() + 1);
                            input.value = adjustedStartDate.toISOString().split('T')[0];
                        } else {
                            input.value = '';
                        }
                    });

                    document.querySelectorAll('[name="end_date"]').forEach(input => {
                        if (endDate) {
                            let adjustedEndDate = new Date(endDate);
                            adjustedEndDate.setDate(adjustedEndDate.getDate() + 1);
                            input.value = adjustedEndDate.toISOString().split('T')[0];
                        } else {
                            input.value = '';
                        }
                    });
                });

                grid.appendChild(dayElement);
            }
        }

        function clearCalendarSelection() {
            document.querySelectorAll('.selected-start, .selected-end, .selected-between').forEach(el => {
                el.classList.remove('selected-start', 'selected-end', 'selected-between');
            });
        }

        function highlightDateRange() {
            document.querySelectorAll('.calendar-day').forEach(dayEl => {
                const day = parseInt(dayEl.textContent);
                const currentDateObj = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
                if (currentDateObj > startDate && currentDateObj < endDate) {
                    dayEl.classList.add('selected-between');
                }
            });
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    </script>
</body>

</html>