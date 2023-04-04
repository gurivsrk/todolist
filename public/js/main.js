
$( "#sortable-table tbody" ).sortable();


function addList(list){
    return `<tr id="${list['id']}" class="">
                <td class="text-center checkBox">
                    <input type="checkBox"  class="mark-done checkbox">
                </td>
                <td>${list['list']}</td>
                <td class="text-center">
                    <button class="delete-btn" data-id="${list['id']}">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </td>
        </tr>`

}


$('#UpdateOrder').on('click',function(){
    if(confirm('save order?')){
        let order = [];
        for(let tr of $('#sortable-table tr')){
            order.push(tr.id) 
        }
        ajaxF('post', $(this).data('url'), {ids : order.join(',')})
    }
})

$('#addTask').on('submit',function (e) {
    e.preventDefault();
    document.querySelector('input[type="submit"]').disabled = true;
    ajaxF($(this).attr('method'), $(this).attr('action'), $(this).serialize(),true)
    
});

$('.mark-done').on('click',function(){
    if(confirm('sure to change status')){
        $(this).parent().parent().toggleClass('checked')
        ajaxF('post', '/complete/task', {id : $(this).parent().parent().attr('id')})
    }
})
$('.delete-btn').on('click',function(){
    if(confirm('sure to delete task')){
        ajaxF('post', '/delete/task', {id : $(this).data('id')})
        $(this).parent().parent().remove();
    }
})

$('#showAll').on('click',function(){
    $('#sortable-table').toggleClass('show')
})