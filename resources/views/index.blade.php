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
    
   <div class="container py-5 text-center">
    <div class="card p-4 mb-4 bg-light">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <h4 id="weatherCity">Cairo</h4>
                <p id="weatherDescription">Loading...</p>
                <strong id="weatherTemp" class="text-primary fs-4"></strong>
            </div>
            <div class="col-md-3">
                <h4>Total Sales</h4>
                <p id="totalSalesValue">Loading...</p>
            </div>
            <div class="col-md-3">
                <h4>Most Sold Product</h4>
                <p id="mostSoldProduct">Loading...</p>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <h2 class="text-center mb-4">📦 Orders Dashboard</h2>
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
        <div id="paginationLinks" class="d-flex justify-content-center mt-3"></div>
        

<div class="col-md-3">
    <h4>AI Suggestions</h4>
    <div class="ai-container">
        <!-- AI SVG Image -->
        <div class="ai-image">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48">
                <circle cx="15.5" cy="16.5" r="12.5" fill="#1976d2"></circle>
                <path fill="#4caf50" d="M44,17.5c0,1.381-1.12,2.5-2.5,2.5S39,18.881,39,17.5c0-1.381,1.12-2.5,2.5-2.5S44,16.119,44,17.5z"></path>
                <path fill="#ff3d00" d="M39,25c0,2.761-2.238,5-5,5c-2.762,0-5-2.239-5-5c0-2.761,2.238-5,5-5C36.762,20,39,22.239,39,25z"></path>
                <path fill="#ffc107" d="M40,38c0,3.314-2.686,6-6,6s-6-2.686-6-6c0-3.314,2.686-6,6-6C37.314,32,40,34.687,40,38z"></path>
            </svg>
        </div>
        <!-- AI Text and Suggestions -->
        <div id="aiSuggestionsText" class="ai-suggestions-text">
            <!-- Dynamic suggestions will appear here -->
            Loading suggestions...
        </div>
    </div>
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
        window.fetchOrders = function (page = 1) {
            $.ajax({
                url: `/api/orders?page=${page}`,
                type: 'GET',
                success: function (data) {
                    const orders = data.data;
                    loadOrdersIntoTable(orders);
                    updatePaginationLinks(data.links);
                },
                error: function () {
                    showMessage('Error fetching orders.');
                }
            });
        };

        fetchOrders();
        fetchWeather();
        fetchSalesAndTopProduct();
        aiSuggestionsText();

        function updatePaginationLinks(links) {
            const paginationContainer = $('#paginationLinks');
            paginationContainer.empty();

            const getPageNumber = (url) => {
                if (!url) return null;
                const params = new URLSearchParams(url.split('?')[1]);
                return params.get('page');
            };

            const prevPage = getPageNumber(links.prev);
            const nextPage = getPageNumber(links.next);

            if (prevPage) {
                paginationContainer.append(`<button class="btn btn-secondary" onclick="${`fetchOrders(${prevPage})`}">Previous</button>`);
            }

            if (nextPage) {
                paginationContainer.append(`<button class="btn btn-secondary" onclick="${`fetchOrders(${nextPage})`}">Next</button>`);
            }
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
        };

        function fetchWeather() {
            $.ajax({
                url: 'api/weather-forecast',
                type: 'GET',
                success: function (data) {
                    const current = data.list[0];
                    const description = current.weather[0].description;
                    const temp = current.main.temp;

                    $('#weatherDescription').text(description.charAt(0).toUpperCase() + description.slice(1));
                    $('#weatherTemp').text(`${temp.toFixed(1)}°C`);
                },
                error: function () {
                    $('#weatherDescription').text('Unable to fetch weather data.');
                }
            });
        }

        function fetchSalesAndTopProduct() {
            $.ajax({
                url: '/api/orders/total-sales',
                type: 'POST',
                success: function (data) {
                    $('#totalSalesValue').text(`$${data.total_sales.toFixed(2)}`);
                },
                error: function () {
                    $('#totalSalesValue').text('Error fetching sales.');
                }
            });

            $.ajax({
                url: '/api/orders/most-sold',
                type: 'POST',
                success: function (data) {
                    const productName = data.most_sold.original.product_name;
                    const totalQuantity = data.most_sold.original.total_quantity;
                    $('#mostSoldProduct').text(`${productName} (${totalQuantity} sold)`);
                },error: function () {
                    $('#mostSoldProduct').text('Error fetching product.');
                }
            });
        }

        function aiSuggestionsText(){
            $.ajax({
                url: 'api/product-suggestions',
                type: 'GET',
                success: function (response) {
                    const mostSoldOrders = response.orders;
                    const weather = response.weather;
                    const suggestions = response.suggestions;

                    let ordersHTML = '<ul>';
                    mostSoldOrders.forEach(order => {
                        ordersHTML += `<li>${order.product_name} (${order.total_quantity} sold)</li>`;
                    });
                    ordersHTML += '</ul>';

                    const weatherHTML = `
                        <p>Weather: ${weather.temp_c}°C, ${weather.condition.text}</p>
                        <p>Location: ${weather.location.name}, ${weather.location.country}</p>
                    `;

                    let suggestionsHTML = '<ul>';
                    suggestions.forEach(suggestion => {
                        suggestionsHTML += `<li>${suggestion}</li>`;
                    });
                    suggestionsHTML += '</ul>';

                    $('#orderList').html(ordersHTML);
                    $('#weatherInfo').html(weatherHTML);
                    $('#suggestions').html(suggestionsHTML);

                    let aiSuggestionsText = `<p>Based on the most sold orders and the current weather, here are some suggested products:</p>`;
                    aiSuggestionsText += suggestions.map(suggestion => `<p>${suggestion}</p>`).join('');
                    $('#aiSuggestionsText').html(aiSuggestionsText);
                },
                error: function () {
                    $('#aiSuggestionsText').text('Error fetching suggestions.');
                }
            });

        }

        window.Echo.channel('orders')
            .listen('.order.created', () => {
                fetchOrders();
                fetchSalesAndTopProduct();
            })
            .error((error) => {
                console.error('Channel subscription error:', error);
            });
        });
</script>
</body>
</html>
