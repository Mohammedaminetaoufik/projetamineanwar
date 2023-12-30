

function showProductItems() {
    $.ajax({
        url: "./adminView/viewAllProducts.php",
        method: "post",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

function showCategory() {
    $.ajax({
        url: "./adminView/viewCategories.php",
        method: "post",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}


function showCustomers() {
    $.ajax({
        url: "./adminView/viewCustomers.php",
        method: "post",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

// active fonction

function setactive(id) {
    $.ajax({
        url: "./controller/updateactive.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            if (data === "success") {
                showCustomers(); 
            } else {
                alert("Error updating user activity.");
            }
        }
    });
}


function showOrders() {
    $.ajax({
        url: "./adminView/viewAllOrders.php",
        method: "post",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

function ChangeOrderStatus(id) {
    $.ajax({
        url: "./controller/updateOrderStatus.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Order Status updated successfully');
            showOrders();
        }
    });
}

function ChangePay(id) {
    $.ajax({
        url: "./controller/updatePayStatus.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Payment Status updated successfully');
            showOrders();
        }
    });
}


//add product data
function addItems() {
    var p_name = $('#p_name').val();
    var p_desc = $('#p_desc').val();
    var p_price = $('#p_price').val();
    var p_quantity=$('#p_quantity').val();
    var category = $('#category').val();
    var upload = $('#upload').val();
    var file = $('#file')[0].files[0];

    var fd = new FormData();
    fd.append('p_name', p_name);
    fd.append('p_desc', p_desc);
    fd.append('p_price', p_price);
    fd.append('p_quantity', p_quantity);
    fd.append('category', category);
    fd.append('file', file);
    fd.append('upload', upload);
    $.ajax({
        url: "./controller/addItemController.php",
        method: "post",
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data); 
            alert('Product Added successfully.');
            showProductItems();
        }
    });
}

//edit product data
function itemEditForm(id) {
    $.ajax({
        url: "./adminView/editItemForm.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

//update product after submit
function updateItems() {
    var product_id = $('#product_id').val();
    var p_name = $('#p_name').val();
    var p_desc = $('#p_desc').val();
    var p_price = $('#p_price').val();
    var p_quantity =$('#p_quantity').val();
    var category = $('#category').val();
    var existingImage = $('#existingImage').val();
    var newImage = $('#newImage')[0].files[0];
    var fd = new FormData();
    fd.append('product_id', product_id);
    fd.append('p_name', p_name);
    fd.append('p_desc', p_desc);
    fd.append('p_price', p_price);
    fd.append('p_quantity', p_quantity);
    fd.append('category', category);
    fd.append('existingImage', existingImage);
    fd.append('newImage', newImage);

    $.ajax({
        url: './controller/updateItemController.php',
        method: 'post',
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
            alert('Data Update Success.');
            
            showProductItems();
        }
    });
}

//delete product data
function itemDelete(id) {
    $.ajax({
        url: "./controller/deleteItemController.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Items Successfully deleted');
            
            showProductItems();
        }
    });
}

//delete costumer data
function deletCustomers(id) {
    $.ajax({
        url: "./controller/deletCustomers.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('costumer deleted');
            
            showCustomers();

        }
    });
}

function deleteOrder(orderID) {
    console.log("Deleting order with ID: " + orderID);
    var confirmation = confirm("Are you sure you want to delete this order?");
    if (confirmation) {
        // Send AJAX request to deletorder.php with the orderID
        $.ajax({
            type: "POST",
            url: "deletorder.php",
            data: { orderID: orderID },
            success: function (response) {
                console.log(response); // Log the response for debugging
                // Handle the response (e.g., refresh the page or update the table)
                location.reload(); // Reload the page for simplicity
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}



//delete cart data
function cartDelete(id) {
    $.ajax({
        url: "./controller/deleteCartController.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Cart Item Successfully deleted');
           
            showMyCart();
        }
    });
}

function eachDetailsForm(id) {
    $.ajax({
        url: "./view/viewEachDetails.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}



//delete category data
function categoryDelete(id) {
    $.ajax({
        url: "./controller/catDeleteController.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Category Successfully deleted');
            
            showCategory();
        }
    });
}











function search(id) {
    $.ajax({
        url: "./controller/searchController.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            $('.eachCategoryProducts').html(data);
        }
    });
}


function quantityPlus(id) {
    $.ajax({
        url: "./controller/addQuantityController.php",
        method: "post",
        data: { record: id },
        success: function (data) {
           
            showMyCart();
        }
    });
}
function quantityMinus(id) {
    $.ajax({
        url: "./controller/subQuantityController.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            
            showMyCart();
        }
    });
}

function checkout() {
    $.ajax({
        url: "./view/viewCheckout.php",
        method: "post",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}


function removeFromWish(id) {
    $.ajax({
        url: "./controller/removeFromWishlist.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Removed from wishlist');
        }
    });
}


function addToWish(id) {
    $.ajax({
        url: "./controller/addToWishlist.php",
        method: "post",
        data: { record: id },
        success: function (data) {
            alert('Added to wishlist');
        }
    });
}