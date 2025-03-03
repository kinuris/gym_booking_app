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
    <div class="max-w-3xl mx-auto my-12 bg-gray-800/50 backdrop-blur-sm shadow-2xl rounded-xl overflow-hidden border border-gray-700">
        <div class="flex md:flex-row flex-col p-8">
            <div class="md:w-1/3 w-full flex justify-center">
                <div class="relative">
                    <img class="object-cover w-48 h-48 rounded-full shadow-xl border-4 border-blue-700/50"
                        src="{{ asset('storage/' . $instructor->profile_image) }}"
                        alt="{{ $instructor->fullname }}">
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-blue-700 to-blue-500 px-4 py-1 rounded-full text-sm font-semibold shadow-lg">
                        Instructor
                    </div>
                </div>
            </div>
            <div class="md:w-2/3 w-full md:pl-6 md:mt-0 mt-8">
                <h2 class="text-2xl font-bold text-blue-400 flex items-center">
                    {{ $instructor->fullname }}
                    <span class="ml-2 bg-blue-600/20 text-blue-300 text-xs px-2 py-1 rounded">Professional Trainer</span>
                </h2>
                <p class="text-gray-300 mt-2 leading-relaxed">{{ $instructor->bio }}</p>
                <div class="mt-4 flex items-center">
                    <div class="flex">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-400 text-sm">4.0 (24 reviews)</span>
                </div>
            </div>
        </div>

        <div class="px-8 pb-8">
            <div class="flex justify-center mb-6 gap-4">
                <button id="monthlyButton" class="bg-blue-600 hover:bg-blue-700 transition-colors duration-300 flex-1 text-white font-bold py-3 px-6 rounded-lg shadow-lg flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Monthly Plan
                </button>
                <button id="hourlyButton" class="bg-gray-700 hover:bg-blue-600 transition-colors duration-300 flex-1 text-white font-bold py-3 px-6 rounded-lg shadow-lg flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
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

            <div class="mt-6 bg-gray-700/30 rounded-lg border border-gray-600/50 overflow-hidden">
                <div class="bg-gray-800/70 py-3 px-4">
                    <div class="flex justify-between items-center">
                        <button id="prevMonth" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Prev
                        </button>
                        <h3 id="monthYear" class="text-lg font-bold text-blue-300"></h3>
                        <button id="nextMonth" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            Next
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="calendar" id="calendarGrid"></div>
                    <div class="mt-4 flex gap-4 text-xs text-gray-400">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-600 rounded-sm mr-1"></div>
                            <span>Start Date</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-600 rounded-sm mr-1"></div>
                            <span>End Date</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="monthlyRateForm" class="rate-form space-y-6 mt-6 bg-gray-700/30 rounded-lg border border-gray-600/50 p-6">
                <div class="flex justify-between items-center border-b border-gray-600/50 pb-4">
                    <h3 class="text-xl font-bold text-blue-400">Monthly Training Plan</h3>
                    <div class="text-green-400 font-bold text-lg">{{ number_format($instructor->monthly_rate, 2) }} PHP</div>
                </div>
                <form action="/session/schedule/monthly" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <input type="hidden" name="start_date">
                    <input type="hidden" name="end_date">
                    <input type="hidden" name="location" value="N/A">
                    
                    <div class="flex justify-center">
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Schedule Monthly Session
                        </button>
                    </div>
                </form>
            </div>

            <div id="hourlyRateForm" class="rate-form hidden space-y-6 mt-6 bg-gray-700/30 rounded-lg border border-gray-600/50 p-6">
                <div class="flex justify-between items-center border-b border-gray-600/50 pb-4">
                    <h3 class="text-xl font-bold text-blue-400">Hourly Training Plan</h3>
                    <div class="text-green-400 font-bold text-lg">{{ number_format($instructor->hourly_rate, 2) }} PHP</div>
                </div>
                <form action="/session/schedule/hourly" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <input type="hidden" name="start_date">
                    <input type="hidden" name="end_date">
                    <input type="hidden" name="location" value="N/A">
                    
                    <div class="flex justify-center">
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Schedule Hourly Session
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