@extends('admin.layouts.main')

@php
    $pageTitle = "Port Calendar";
@endphp

@section('main-container')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Port Calendar</h3>
                            <div class="nk-block-des text-soft">
                                <p>Select a date to configure port details.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="calendar-navigation">
                    <button id="prev-month" class="btn btn-secondary">Previous Month</button>
                    <button id="next-month" class="btn btn-secondary">Next Month</button>
                </div>
                <div id="calendar-container">
                    <!-- Calendar will be populated by JavaScript -->
                </div>

                <!-- Port Details Form -->
                <div class="nk-block mt-4">
                    <form action="{{ route('admin.defaultPort.setup') }}" method="POST">
                        @csrf
                        <div class="card card-bordered">                            
                            <div class="card-inner">
                                <h3 class="nk-block-title page-title">Default Setup</h3>
                                <div class="row gy-4" id="port-entries">
                                    <!-- Port entry fields will be dynamically added here -->
                                </div>
                                <button type="button" class="btn btn-icon mb-2" id="add-port"><em class="icon ni ni-plus-fill-c"></em> Add Port</button>

                                <!-- This hidden field will store the JSON data on submit -->
                                <input type="hidden" name="ports" id="ports-json">

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Update Settings</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of Port Details Form -->                
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const calendarContainer = document.getElementById('calendar-container');
    let currentDate = new Date();
    const monthsToShow = 12; // Show the next 12 months
    const portsData = @json($portsData); // Port data for the calendar
    const defaultPortsData = @json($setting->default_port); // Default port data

    function generateCalendar(month, year) {
        const monthContainer = document.createElement('div');
        monthContainer.className = 'month-container';

        const monthTitle = document.createElement('h4');
        monthTitle.className = 'month-title';
        monthTitle.innerText = new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric' }).format(new Date(year, month));
        monthContainer.appendChild(monthTitle);

        const daysContainer = document.createElement('div');
        daysContainer.className = 'days-container';

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const today = new Date();
        today.setHours(0, 0, 0, 0); // Clear time for comparison

        for (let i = 0; i < firstDay; i++) {
            const blankDay = document.createElement('div');
            blankDay.className = 'day blank';
            daysContainer.appendChild(blankDay);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'day';
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            dayElement.dataset.date = dateStr;
            dayElement.innerText = day;

            const date = new Date(year, month, day);
            date.setHours(0, 0, 0, 0); // Clear time for comparison

            if (date < today) {
                // Disable past dates
                dayElement.classList.add('disabled');
            } else if (portsData[dateStr]) {
                // If port data exists for the date, highlight it
                dayElement.classList.add('has-ports');
            } else {
                // If no port data, show tooltip on hover
                dayElement.title = 'Please setup port details';
            }

            dayElement.addEventListener('click', function() {
                if (!dayElement.classList.contains('disabled')) {
                    const setupUrl = `{{ url('admin/dashboard/portDetails/setup') }}/${dateStr}`;
                    window.location.href = setupUrl;
                }
            });

            daysContainer.appendChild(dayElement);
        }

        monthContainer.appendChild(daysContainer);
        calendarContainer.appendChild(monthContainer);
    }

    function showNextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        calendarContainer.innerHTML = '';
        generateCalendar(currentDate.getMonth(), currentDate.getFullYear());
    }

    function showPreviousMonth() {
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();

        if (currentDate.getMonth() > currentMonth || currentDate.getFullYear() > currentYear) {
            currentDate.setMonth(currentDate.getMonth() - 1);
            calendarContainer.innerHTML = '';
            generateCalendar(currentDate.getMonth(), currentDate.getFullYear());
        }
    }

    document.getElementById('next-month').addEventListener('click', showNextMonth);
    document.getElementById('prev-month').addEventListener('click', showPreviousMonth);

    generateCalendar(currentDate.getMonth(), currentDate.getFullYear());

    // PORT SETUP

    const container = document.getElementById('port-entries');
    const addButton = document.getElementById('add-port');
    let portCount = 0;

    function generateTimeOptions(selectedTime = '') {
        let options = '<option value="">Select Time</option>';
        for (let hour = 0; hour < 24; hour++) {
            const h = hour.toString().padStart(2, '0');
            options += `<option value="${h}:00"${selectedTime === `${h}:00` ? ' selected' : ''}>${h}:00</option>`;
            options += `<option value="${h}:30"${selectedTime === `${h}:30` ? ' selected' : ''}>${h}:30</option>`;
        }
        return options;
    }

    function addTimeSlot(container, namePrefix, selectedTime = '', maxCapacity = '') {
        const slotContainer = document.createElement('div');
        slotContainer.className = 'time-slot mb-2';
        slotContainer.innerHTML = `
            <div class="d-flex align-items-center">
                <select class="form-control d-inline-block w-50" name="${namePrefix}[]">${generateTimeOptions(selectedTime)}</select>
                <input type="number" class="form-control d-inline-block w-30 ml-2" name="${namePrefix}_capacity[]" placeholder="Max Capacity" value="${maxCapacity}">
                <button type="button" class="btn btn-icon remove-time-slot ml-2"><em class="icon ni ni-minus-fill-c"></em></button>
            </div>
        `;
        container.appendChild(slotContainer);
        slotContainer.querySelector('.remove-time-slot').addEventListener('click', function() {
            slotContainer.remove();
            updateJson();
        });
        slotContainer.querySelector('select').addEventListener('change', updateJson);
        slotContainer.querySelector('input').addEventListener('change', updateJson);
    }

    function addPort(portData = {port_name: '', port_price: '', charter_boat_price: '', arrival_schedules: [], departure_schedules: []}) {
        const index = portCount++;
        const html = `
            <div class="card mb-3 port-entry" data-index="${index}">
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <label class="form-label">Port ${index} Name</label>
                            <input type="text" class="form-control" name="port_name[${index}]" value="${portData.port_name || ''}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price (One Side Per Person)</label>
                            <input type="number" class="form-control" name="port_price[${index}]" placeholder="Enter price" value="${portData.port_price || ''}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Charter Boat Price (One Side Per Person)</label>
                            <input type="number" class="form-control" name="charter_boat_price[${index}]" placeholder="Enter price" value="${portData.charter_boat_price || ''}">
                        </div>                                  
                        <div class="col-md-2 text-right">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="button" class="btn btn-danger remove-port mb-2">Remove Port</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Mersing To The Rock Resorts</label>
                            <div class="arrival-times"></div>
                            <a href="javascript:void(0)" class="add-arrival-time text-success">+ Add Arrival Time</a>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">The Rock Resorts To Mersing</label>
                            <div class="departure-times"></div>
                            <a href="javascript:void(0)" class="add-departure-time text-success">+ Add Departure Time</a>
                        </div>
                    </div>
                </div>
            </div>
            `;            

        container.insertAdjacentHTML('beforeend', html);
        const portEntry = container.lastElementChild;
        const portNameInput = portEntry.querySelector(`[name="port_name[${index}]"]`);
        const portPriceInput = portEntry.querySelector(`[name="port_price[${index}]"]`);
        const charterBoatPriceInput = portEntry.querySelector(`[name="charter_boat_price[${index}]"]`);
            
        portNameInput.addEventListener('change', updateJson);
        portPriceInput.addEventListener('change', updateJson);
        charterBoatPriceInput.addEventListener('change', updateJson);
            
        portEntry.querySelector('.add-arrival-time').addEventListener('click', () => addTimeSlot(portEntry.querySelector('.arrival-times'), `arrival_schedule[${index}]`));
        portEntry.querySelector('.add-departure-time').addEventListener('click', () => addTimeSlot(portEntry.querySelector('.departure-times'), `departure_schedule[${index}]`));
            
        portEntry.querySelector('.remove-port').addEventListener('click', function() {
            portEntry.remove();
            updateJson();
        });
    
        (portData.arrival_schedules || []).forEach(schedule => addTimeSlot(portEntry.querySelector('.arrival-times'), `arrival_schedule[${index}]`, schedule.time, schedule.capacity));
        (portData.departure_schedules || []).forEach(schedule => addTimeSlot(portEntry.querySelector('.departure-times'), `departure_schedule[${index}]`, schedule.time, schedule.capacity));
        
        updateJson();
    }

    addButton.addEventListener('click', function() {
        addPort();
    });

    function updateJson() {
        const entries = Array.from(container.querySelectorAll('.port-entry'));
        const data = entries.map(entry => {
            return {
                port_name: entry.querySelector('[name^="port_name"]').value,
                port_price: entry.querySelector('[name^="port_price"]').value,
                charter_boat_price: entry.querySelector('[name^="charter_boat_price"]').value,
                arrival_schedules: Array.from(entry.querySelectorAll('.arrival-times .time-slot')).map(slot => {
                    return {
                        time: slot.querySelector('select').value,
                        capacity: slot.querySelector('input').value
                    };
                }),
                departure_schedules: Array.from(entry.querySelectorAll('.departure-times .time-slot')).map(slot => {
                    return {
                        time: slot.querySelector('select').value,
                        capacity: slot.querySelector('input').value
                    };
                })
            };
        });
        document.getElementById('ports-json').value = JSON.stringify(data);
    }

    // Check if there's existing default port data and populate the form
    if (defaultPortsData && defaultPortsData.length) {
        defaultPortsData.forEach(port => addPort(port));
    } else {
        addPort(); // Initialize with one port entry by default    
    }
});


</script>

<style>

    #calendar-container {
        background: #ffffff;
        padding: 20px;
        margin-top: 15px;
    }

    .month-container {
        margin-bottom: 20px;
    }

    .day.has-ports {
        background-color: #00b72c;
        border-color: #1b9b3a;
        color: #ffffff;
    }

    .day.has-ports:hover {
        background-color: #c3e6cb; /* Darker green on hover */
    }

    .day.disabled {
        background-color: #e0e0e0;
        color: #a0a0a0;
        cursor: not-allowed;
        pointer-events: none;
    }


    .month-title {
        text-align: center;
        margin-bottom: 10px;
    }

    .days-container {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }

    .day {
        background-color: #798bff;
        border: 1px solid #ffffff;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        color: #fff;
        border-radius: 10px;
    }

    .day:hover {
        background-color: #e0e0e0;
    }

    .blank {
        visibility: hidden;
    }
</style>
@endsection
