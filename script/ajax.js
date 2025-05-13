// START => UPLOAD USERS

function create_table(page) {
    $.post('../data_base/function.php', {page: page, action: 'all_users'}, function(response) {
        if (response.success) {
            $('.table-container').css('display', 'block');
            $('.table-container tbody').html('');
            let users_info = response.users_info;
            for (let key in users_info) {
                $('.table-container tbody').append(`
                    <tr>
                        <td><img src="${users_info[key].photo}" alt="photo" style="width: 50px; height: 50px; border-radius: 5px;"></td>
                        <td title='${users_info[key].name}'>${users_info[key].name}</td>
                        <td title='${users_info[key].company}'>${users_info[key].company}</td>
                        <td title='${users_info[key].username}'>${users_info[key].username}</td>
                        <td title='${users_info[key].email}'>${users_info[key].email}</td>
                        <td title='${users_info[key].address}'>${users_info[key].address}</td>
                        <td title='${users_info[key].zip}'>${users_info[key].zip}</td>
                        <td title='${users_info[key].state}'>${users_info[key].state}</td>
                        <td title='${users_info[key].country}'>${users_info[key].country}</td>
                        <td title='${users_info[key].phone}'>${users_info[key].phone}</td>
                        <td data-id='${users_info[key].user_id}' class="action-buttons">
                            <button class="todoList"><span>Todos</span></button>
                            <button class="edit"><span>Edit</span></button>
                            <button class="delete"><span>Delete</span></button>
                        </td>
                    </tr>
                `);
            }
    
            $('#pagination').html('');
            for (let i = 1; i <= response.total_pages; i++) {
                $('#pagination').append(`<a href="javascript:void(0)" class="page-link" data-page="${i}">${i}</a>`)
            }
        }
    }, 'json');
}

create_table(1);

// START => UPLOAD TODOS

function create_todos(pages = 1) {
    $.post('../data_base/function.php', {pages: pages, action: 'all_todos'}, function(response) {
        if (response.success) {
            $('.todo-container').css('display', 'block');
            $('.todo-container tbody').html('');
            let todos_info = response.todos_info;
            for (let key in todos_info) {
                $('.todo-container tbody').append(`
                    <tr style='${todos_info[key].completed_task ? "background-color: #78ff7d" : ''}'>
                        <td><img src="${todos_info[key].user_photo}" alt="photo" style="width: 50px; height: 50px; border-radius: 5px;"></td>
                        <td title='${todos_info[key].user_name}'>${todos_info[key].user_name}</td>
                        <td title='${todos_info[key].task_title}'>${todos_info[key].task_title}</td>
                        <td data-id='${todos_info[key].task_id}' class="action-buttons">
                            <button class="edit-todo"><span>Edit</span></button>
                            <button class="delete-todo"><span>Delete</span></button>
                        </td>
                    </tr>
                `);
            }

            $('#pagination_todo').html('');
            for (let i = 1; i <= response.total_pages; i++) {
                $('#pagination_todo').append(`<a href="javascript:void(0)" class="page-link" data-page="${i}">${i}</a>`)
            }
        } else {
            alert(response.error);
            $('.todo-container').css('display', 'none');
        }
    }, 'json');
}

create_todos(1);

// START => PAGINATION

$(document).on('click', '.page-link', function() {
    if($(this).closest('div').hasClass('users-pagination')){
        create_table($(this).attr('data-page'));
    }else{
        create_todos($(this).attr('data-page'))
    }
});


// START => SEARCH

$('.open_search').click(function(){
    if($(this).hasClass('rotate')){
        $(this).removeClass('rotate');
        $(this).closest('.search_box').removeClass('width');
    }else{
        $(this).addClass('rotate');
        $(this).closest('.search_box').addClass('width');
    }
})

$(document).click(function(event) {
    if (!$(event.target).closest('.search_box').length) {
        $('.search_box').removeClass('width');
        $('.open_search').removeClass('rotate');
    }
});

$('.search_input').on('input', function(){ 
    let searchType = $('.search_input').attr('data-search');
    let action = searchType === 'users_search' || searchType === 'todo_search' ? searchType : null;
    let search_input = $.trim($(this).val());

    if(search_input.length > 2 && search_input.length < 150){
        let searchData = {
            text: search_input,
            action: action
        }

        $.post('../data_base/function.php', searchData, function(searched){
            $('tbody').html('');
            if(searched.success){
                $('#pagination_todo, #pagination').html('');
                $('tbody').html(searched.html);
            }
            else{
                $('tbody').html('<tr><td colspan="11">No results found</td></tr>');
            }
        }, 'json');
    }else{
        searchType == 'users_search' ? create_table() : searchType == 'todo_search' && create_todos();
    }
});

// START => DELETE & EDIT


$(document).on('click', '.delete, .delete-todo', function() {
    let action = $(this).hasClass('edit') ? 'delete' : 'delete_todo';
    let userId = {
        id: $(this).closest('td').data('id'),
        action: action
    }
    $.post('../data_base/function.php', userId, function(response){
        if(response.success){
            alert(response.message);
            (action === 'delete' ? create_table : create_todos)();
        }else{
            alert(response.error);
        }
    }, 'json');
});

$(document).on('click', '.edit, .edit-todo', function() {
    let action = $(this).hasClass('edit') ? 'edit' : 'edit_todo';
    let userId = {
        id: $(this).closest('td').data('id'),
        action: action
    }
    $.post('../data_base/function.php', userId, function(response){
        if(!response.success){
            alert(response.error);
        }else{
            window.location = response.redirect;
        }
    }, 'json');
});
    
// START => INPUT BORDER ANIMATIONS

$('.input_zone').focus(function() {
    $(this).next('.border_bottom').css('width', '100%');
});

$('.input_zone').blur(function() {
    $(this).next('.border_bottom').css('width', '0');
});

$('.input_zone').on('input', function(){
    if($(this).val() == ''){
        $(this).prev('label').addClass('to_center');
    }else{
        $(this).prev('label').removeClass('to_center');
    }
})

// START => UPLOAD IMAGE


$('.photo_input').change(function(){
    var curElement = $(this).prev('img');
    var reader = new FileReader();
    reader.onload = function (e) {
        curElement.attr('src', e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
});


// START => UPDATE


$('.edit_user').click(function(){
    let formData = new FormData();
    formData.append('id', $(this).attr('data-id'));
    formData.append('name', $('.name_input').val());
    formData.append('company', $('.company_input').val());
    formData.append('username', $('.username_input').val());
    formData.append('email', $('.email_input').val());
    formData.append('address', $('.address_input').val());
    formData.append('zip', $('.zip_input').val());
    formData.append('state', $('.state_input').val());
    formData.append('country', $('.country_input').val());
    formData.append('phone', $('.phone_input').val());
    formData.append('photo', $('.photo_input')[0].files[0] || '');
    formData.append('action', 'user_update');

    
    $.ajax({
        url: '../data_base/function.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('Successfully updated!');
                window.location = response.redirect;
            } else {
                let errors = response.error;
                $('.error_message').html('');
                for (let key in errors) {
                    if(key == 'id'){
                        alert(errors[key]);
                    }
                    $('.' + key + '_error').html(errors[key]);
                    
                }
            }
        }
    });
})

// START => UPDATE TODO

$('.edit_todo').click(function(){
    $('.error_message').html('');
    let new_todo = {
        id:$(this).attr('data-id'),
        user: $('.names_input').val(),
        competed: $('.completed_input').val(),
        task:$('.task_input').val(),
        action: 'update_todo'
    }


    console.log(new_todo);
    
    $.post('../data_base/function.php', new_todo, function(response){
        if(response.success){
            alert(response.message);
            window.location = response.redirect;
        }else{
            for (let key in response.errors){
                if(key == 'id'){
                    alert(response.errors[key]);
                }
                $('.' + key + '_error').text(response.errors[key]);
            }
        }
    }, 'json')
})

// START => USER TODOS VIEW

$(document).on('click', '.todoList', function(){
    let user_todos = {
        id: $(this).closest('td').data('id'),
        action: 'user_todos'
    }

    $.post('../data_base/function.php', user_todos, function(todos){
        if(todos.success){
            window.location = todos.redirect;
        }else{
            alert(todos.message);
        }
    }, 'json');
})
