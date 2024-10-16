<?php 

$select_1 = "select";
$select_2 = "non";
?>

<?php  

require('../include/node/function.php');
require('../include/node/config.php');


if(!isset($_SESSION['auth'])){
	redirect("../signin.php", "Try again");
}

$intro = $_SESSION['status'];




$notifyJsonFile = 'api/notify_response.json';
$msg = '';

if (!file_exists($notifyJsonFile)) {
    $msg = 'No history found.';
}

$notifications = json_decode(file_get_contents($notifyJsonFile), true);

if (empty($notifications)) {
    $msg = 'No history available.';
}


foreach ($notifications as $notification) {
        if($notification['action'] == "respond"){
            
        $msg .= '
            <li>
                    <div class="detail d-flex justify-content-between">
                        <span class="name">' . htmlspecialchars($notification['user_name']) . ' Order</span>
                    </div>
                    <div class="sub d-flex justify-content-between align-items-center mt-2">
                        <div class="btn-group">
                        <form method="POST">
                            <input class="id" type="hidden" value="' . htmlspecialchars($notification['id']) . '"/>
                            <button class="btn btn-primary deliver" name="respond">Delivered</button>
                            <button class="btn btn-danger ignore" name="ignore">Ignore</button>
                        </form>
                        </div>
                    </div>
                </li>
        ';
        }

    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('header/header.php') ?>

    <style>
    	.main-nav .select{
    		color: rgb(20, 21, 170);
    	}
    </style>
</head>
<body>

<?php require('header/nav.php')?>


<!-- Content Area -->
<div class="wrapper">
    
    <section class="orders_page mb-4">
        <div class="d-flex justify-content-between align-items-center main">
            <h1>Customers' Orders Remind</h1>
        </div>
        <form>
            <ul class="list-unstyled mt-4">
                <?= $msg ?>
            </ul>
        </form>
    </section>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelector('.deliver').addEventListener('click', function() {
    const id = document.querySelector('.id').value;

    let message = "Delivered";
    sendRespond(id, message);
});

document.querySelector('.ignore').addEventListener('click', function() {
    const id = document.querySelector('.id').value;

    let message = "Ignored";
    sendRespond(id, message);
});

function sendRespond(id, message){

    const idToDelete = id;

        fetch('api/delete_entry.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: idToDelete })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(`${message} successfully!`);
            } else {
                alert('Error entry');
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

</body>
</html>
