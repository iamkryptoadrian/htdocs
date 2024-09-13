@extends('admin.layouts.main')
@php
    $pageTitle = 'Run Commands';
@endphp
@section('main-container')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Run Artisan Commands</h3>
                                <div class="nk-block-des text-soft">

                                </div>
                            </div>
                            <!-- .nk-block-head-content -->
                        </div>
                        <!-- .nk-block-between -->
                    </div>
                    <!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner position-relative card-tools-toggle">
                                    <form id="commandForm">
                                        <div class="form-group">
                                            <label for="command">Enter Artisan Command:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">php artisan</span>
                                                </div>
                                                <input type="text" id="command" name="command" class="form-control" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Run Command</button>
                                    </form>
                                    <div id="commandOutput" class="mt-4">
                                        <h3>Output:</h3>
                                        <pre id="output" style="background-color: #000000; padding: 15px; color:lime"></pre>
                                    </div>
                                </div>
                            </div>
                            <!-- .card-inner-group -->
                        </div>
                        <!-- .card -->
                    </div>
                    <!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('commandForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var command = document.getElementById('command').value;

            fetch('{{ route('admin.runCommand') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        command: command
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('output').textContent = data.output;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
