@extends('admin.layouts.main')

@php
    $pageTitle = "Port Settings for $date";
@endphp

@section('main-container')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Boat Port Settings for {{ $date }}</h3>
                            <div class="nk-block-des text-soft">
                                <p>Add The Arrival / Departure Port for {{ $date }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.bookingSettings.storePort', ['date' => $date]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $setting->id }}">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row gy-4">
                                    <!-- Port Settings Section -->
                                    <div class="row mt-4" id="ports-container">
                                        <button type="button" class="btn btn-icon mb-2" id="add-port"><em class="icon ni ni-plus-fill-c"></em> Add Port</button>
                                    
                                        <div id="port-entries">
                                            <!-- JavaScript will populate this area with port entries -->
                                        </div>
                                    
                                        <!-- This hidden field will store the JSON data on submit -->
                                        <input type="hidden" name="ports" id="ports-json">
                                    </div>
                
                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update Settings</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('port-entries');
        const addButton = document.getElementById('add-port');
        const existingPortsJson = @json($portDataForDate ?? []);
        const timeOptions = generateTimeOptions();
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
                                <label class="form-label">Price (per trip per person)</label>
                                <input type="number" class="form-control" name="port_price[${index}]" placeholder="Enter price" value="${portData.port_price || ''}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Charter Boat Price (per trip per person)</label>
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
    
        const existingPorts = existingPortsJson || [];
        if (existingPorts.length) {
            existingPorts.forEach(addPort);
        } else {
            addPort(); // Add one port entry by default
        }
        
        updateJson();
    });
</script>
    
@endsection
