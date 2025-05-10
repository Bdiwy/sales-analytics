<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @endif
</head>
<body>
<div class="container py-5">
    <div class="card p-3 mb-4 bg-light">
    <div class="d-flex align-items-center">
        <img id="weatherIcon" src="" alt="Weather Icon" width="80" class="me-3" />
        <div>
            <h4 class="mb-1" id="weatherCity">Cairo</h4>
            <p class="mb-0" id="weatherDescription">Loading...</p>
            <strong id="weatherTemp" class="text-primary fs-4"></strong>
        </div>
    </div>
</div>

    <div class="card p-4">
        <h2 class="text-center mb-4">📦 Orders Dashboard</h2>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" id="startDate" class="form-control" />
            </div>
            <div class="col-md-6">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" id="endDate" class="form-control" />
            </div>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <button id="filterOrders" class="btn btn-primary">Filter Orders</button>
        </div>

        <div class="table-responsive">
            <table id="ordersTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="messageContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            fetchOrders();
            fetchWeather();
            $('#filterOrders').click(function () {
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();

                if (startDate && endDate) {
                    fetchOrdersByDateRange(startDate, endDate);
                } else {
                    showMessage('Please select both start and end dates.');
                }
            });

            function fetchOrders() {
                $.ajax({
                    url: '/api/orders',
                    type: 'GET',
                    success: function (data) {
                        const orders = data; 
                        loadOrdersIntoTable(orders);
                    },
                    error: function () {
                        showMessage('Error fetching orders.');
                    }
                });
            }

            function fetchOrdersByDateRange(startDate, endDate) {
                $.ajax({
                    url: `/api/orders/date-range?startDate=${startDate}&endDate=${endDate}`,
                    type: 'GET',
                    success: function (data) {
                        const orders = data; 
                        loadOrdersIntoTable(orders);
                    },
                    error: function () {
                        showMessage('Error fetching orders for the selected date range.');
                    }
                });
            }

            function loadOrdersIntoTable(orders) {
                const tableBody = $('#ordersTable tbody');
                tableBody.empty(); 

                if (orders.length === 0) {
                    tableBody.append('<tr><td colspan="6" class="text-center">No orders found.</td></tr>');
                } else {
                    orders.forEach(order => {
                        tableBody.append(`
                            <tr>
                                <td>${order.id}</td>
                                <td>${order.product_name}</td>
                                <td>${order.quantity}</td>
                                <td>${order.price}</td>
                                <td>${order.created_at}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="viewOrder(${order.id})">View</button>
                                    <button class="btn btn-warning btn-sm" onclick="editOrder(${order.id})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteOrder(${order.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            }

            function showMessage(message) {
                $('#messageContent').text(message);
                $('#messageModal').modal('show');
            }

            window.viewOrder = function (id) {
                showMessage('View order ' + id);
            }

            window.editOrder = function (id) {
                showMessage('Edit order ' + id);
            }

            window.deleteOrder = function (id) {
                    $.ajax({
                        url: `/api/orders/${id}`,
                        type: 'DELETE',
                        success: function () {
                            showMessage('Order deleted successfully.');
                            fetchOrders();
                        },
                        error: function () {
                            showMessage('Error deleting order.');
                        }
                    });
            }
        function fetchWeather() {
            $.ajax({
                url: 'api/weather-forecast',
                type: 'GET',
                success: function (data) {
                    const current = data.list[0];
                    const iconCode = current.weather[0].icon;
                    const description = current.weather[0].description;
                    const temp = current.main.temp;

                    $('#weatherIcon').attr('src', `https://openweathermap.org/img/wn/${iconCode}@2x.png`);
                    $('#weatherDescription').text(description.charAt(0).toUpperCase() + description.slice(1));
                    $('#weatherTemp').text(`${temp.toFixed(1)}°C`);
                },
                error: function () {
                    $('#weatherDescription').text('Unable to fetch weather data.');
                }
            });
        }

        window.Echo.channel('orders')
            .listen('.order.created', (e) => {
                fetchOrders();
            })
            .error((error) => {
                console.error('Channel subscription error:', error);
            });
        });

    </script>
</body>
</html>
