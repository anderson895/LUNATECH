


<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Manage Users</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($On_Session[0]['user_username']), 0, 1);
        ?>
    </div>
</div>





<!-- User Table Card -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">

    <button id="adduserButton" class="bg-blue-500 text-white py-2 px-4 text-sm rounded-lg flex items-center hover:bg-blue-600 transition duration-300 mb-4">
        <span class="material-icons mr-2 text-base">person_add</span>
        Add New
    </button>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Fullname</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Username</th>
                    <th class="p-3">Position</th>
                    
                    
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/user_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>







</div>



<!-- Modal for Adding Promo -->
<div id="updateUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Information</h3>
        <form id="updateuserForm">

            <div hidden class="mb-4">
                <label for="update_id" class="block text-sm font-medium text-gray-700">ID</label>
                <input type="text" id="update_id" name="update_id" class="w-full p-2 border rounded-md" required>
            </div>


            <div class="mb-4">
                <label for="update_user_fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" id="update_user_fullname" name="update_user_fullname" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="update_user_username" class="block text-sm font-medium text-gray-700">User Name</label>
                <input type="text" id="update_user_username" name="update_user_username" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="update_user_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="update_user_email" name="update_user_email" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="update_admin_password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="text" id="update_admin_password" name="update_admin_password" class="w-full p-2 border rounded-md" >
            </div>

            
            <div class="mb-4">
                <label for="update_user_type" class="block text-sm font-medium text-gray-700">Position</label>
                <select name="update_user_type" id="update_user_type" class="w-full p-2 border rounded-md" required>
                    <option value="General Manager">General Manager</option>
                    <option value="Administrator">Administrator</option>
                </select>
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" class="togglerUpdateUserClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md">Update</button>
            </div>
        </form>
    </div>
</div>




<!-- Modal for Adding Promo -->
<div id="addUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New User</h3>
        <form id="adduserForm">
            
            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

            <div class="mb-4">
                <label for="user_fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" id="user_fullname" name="user_fullname" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="user_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="user_email" name="user_email" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="user_username" class="block text-sm font-medium text-gray-700">User Name</label>
                <input type="text" id="user_username" name="user_username" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="user_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="user_password" name="user_password" class="w-full p-2 border rounded-md" required>
            </div>


            <div class="mb-4">
                <label for="user_type" class="block text-sm font-medium text-gray-700">Position</label>
                <select name="user_type" id="user_type" class="w-full p-2 border rounded-md" required>
                    <option value="General Manager">General Manager</option>
                    <option value="Administrator">Administrator</option>
                   
                </select>
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" class="addUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button id="btnAdduser" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md">Add new</button>
            </div>
        </form>
    </div>
</div>







<?php include "components/footer.php";?>

