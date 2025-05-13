<?php
$title = 'Todos';
$search = 'todo_search';
require_once $_SERVER['DOCUMENT_ROOT']."/pages/parts/header.php";
?>


<div class="todo-container">
  <table>
    <thead>
      <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Title</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<div id="pagination_todo"></div>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/pages/parts/footer.php";
?>