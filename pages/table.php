<?php
$title = 'Users';
$search = 'users_search';
require_once $_SERVER['DOCUMENT_ROOT']."/pages/parts/header.php";
?>


<div class="table-container">
  <table>
    <thead>
      <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Company</th>
        <th>Username</th>
        <th>Email</th>
        <th>Address</th>
        <th>ZIP</th>
        <th>State</th>
        <th>Country</th>
        <th>Phone</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
<div id="pagination" class='users-pagination'></div>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/pages/parts/footer.php";
?>