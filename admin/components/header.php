<?php
session_start();
include('backend/class.php');

$db = new global_class();

if (isset($_SESSION['id'])) {
    $id = intval($_SESSION['id']);

   
    $On_Session = $db->check_account($id);

   
  
    if (!empty($On_Session)) {
        if($_SESSION['user_type']=="Branch Manager"){
          header('location: ../branch_manager/home');
        }
    } else {
       header('location: ../');
    }
} else {
   header('location: ../');
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NDG Company</title>
  <link rel="icon" type="image/png" href="../assets/images/logo/business_logo.jpeg">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 

  

</head>
<body class="bg-gray-100 font-sans antialiased">



<?php include "../function/PageSpinner.php"; ?>


<input hidden type="text" id="user_type" value="<?=$On_Session[0]['user_type']?>">


  <div class="min-h-screen flex flex-col lg:flex-row">
    
  <!-- Sidebar -->
<aside id="sidebar" class="bg-white shadow-lg w-64 lg:w-1/5 xl:w-1/6 p-6 space-y-6 lg:static fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
  <!-- Hide Sidebar Button -->
  <div class="flex items-center space-x-4 p-4 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
  <img src="../assets/images/logo/business_logo.jpeg" alt="Logo" class="w-20 h-20 rounded-full border-2 border-gray-300 shadow-sm transform transition-transform duration-300 hover:scale-105"> <!-- Logo -->
  <h1 class="text-1xl font-bold text-gray-800 tracking-tight text-left lg:text-left hover:text-indigo-600 transition-colors duration-300"><?=$On_Session[0]['user_type']?></h1>
</div>


  <nav class="space-y-4 text-left lg:text-left">
      <a href="dashboard" class="flex items-center lg:justify-start space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">dashboard</span>
          <span>Dashboard</span>
      </a>

      <a href="users" class="flex items-center lg:justify-start space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">manage_accounts</span>
          <span>Manage users</span>
      </a>

      
      <a href="branches" class="flex items-center lg:justify-start space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">add_business</span>
          <span>Manage branches</span>
      </a>


      <a href="product" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">sell </span>
          <span>Products</span>
      </a>


      <a href="list_action_request" class="flex items-center lg:justify-start space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
        <span class="material-icons">assignment</span>
        <span>List of Request</span>
        <span style="display:none;" id="ListOfRequestCounts" class="bg-red-500 text-white text-xs font-semibold rounded-full w-5 h-5 flex items-center justify-center ">
            0
        </span>
    </a>



      <!-- <a href="report" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">description</span>
          <span>Reports</span>
      </a>

      <a href="sales" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
            <span class="material-icons">point_of_sale</span>

          <span>Sales</span>
      </a> -->


      <!-- <a href="settings" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
            <span class="material-icons">admin_panel_settings</span>

          <span>Settings</span>
      </a> -->

      <a href="salesbranches" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
            <span class="material-icons">point_of_sale</span>

          <span>Sales branches</span>
      </a>


      <a href="logout.php">
          <button type="submit" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-red-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
              <span class="material-icons">logout</span>
              <span>Logout</span>
          </button>
        </a>
  </nav>
</aside>



    <!-- Overlay for Mobile Sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden lg:hidden z-40"></div>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 p-8 lg:p-12">
      <!-- Mobile menu button -->
      <button id="menuButton" class="lg:hidden text-gray-700 mb-4">
        <span class="material-icons">menu</span> 
      </button>

   

     